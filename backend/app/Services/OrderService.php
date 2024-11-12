<?php


namespace App\Services;


use App\Models\Contact;
use App\Models\Order;
use App\Models\OrderComment;
use App\Models\OrderPriority;
use App\Models\OrderStatus;
use App\Models\User;
use App\Models\UserStatus;
use App\Services\DTO\ContactDTO;
use App\Services\DTO\ClientDTO;
use App\Services\DTO\OrderDTO;
use App\Services\DTO\Requests\OrderRequest;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;

class OrderService
{
    const MASTER_DISTANCE_AVAILABLE_DELTA = 1000;
    const DEFAULT_RESPONSIBLE_ID = 1;

    public static function create(OrderDTO $orderDTO): bool
    {
        $order = new Order();

//        Поиск/создание клиента
        $contactDto = new ContactDTO(
            null,
            Contact::ENTITY_TYPE_CLIENT,
            Contact::TYPE_PHONE,
            $orderDTO->phone,
        );

        $clientDto = new ClientDTO(
            $orderDTO->name,
            $contactDto
        );

        $client = ClientService::findOrCreate($clientDto);
        $order->client_id = $client->id;

        $priorityId = $orderDTO->isUrgent ? OrderPriority::URGENT : OrderPriority::BASIC;
        $order->order_priority_id = $priorityId;

        $order->address = $orderDTO->address;
        $order->lat = $orderDTO->coords['lat'];
        $order->lon = $orderDTO->coords['lon'];

//        Расчет срока выполнения заказа
        $deadline = $orderDTO->isUrgent ? Carbon::now()->addHours(2) : Carbon::createFromTimestampMs($orderDTO->dateTime);
        if ($deadline < Carbon::now()->addHours(2)) {
            $deadline = Carbon::now()->addHours(2);
        }

        $order->deadline = $deadline->toDateTimeString();

//        Назначение ответственного
        $responsible = self::findResponsible($order);

        $order->user_id = $responsible ?: Order::DEFAULT_RESPONSIBLE_USER_ID;
        $order->status_id = OrderStatus::APPOINTED;

        return $order->save();
    }

    public static function getOrders(OrderRequest $request): array
    {
        $conditions = $request->buildConditions();

        $ordersRequest = Order::limit($request->limit ?? 100)->offset($request->offset ?? 0);

        if (!empty($conditions['where'])) {
            foreach ($conditions['where'] as $condition) {
                $ordersRequest->where($condition[0], $condition[1]);
            }
        }

        if (!empty($conditions['whereIn'])){
            foreach ($conditions['whereIn'] as $condition) {
                $ordersRequest->whereIn($condition[0], $condition[1]);
            }
        }

        $orders = $ordersRequest->with([
                'user' => function ($query) {
                    $query->with('status');
                },
                'status',
                'comments',
                'client' => function ($query) {
                    $query->with('contacts');
                },
                'priority',
            ])
            ->limit($request->limit)
            ->offset($request->offset)
            ->get()
            ->toArray();

        $result = [];
        foreach ($orders as $order) {
            $clientContacts = [];
            if (!empty($order['client']['contacts'])) {
                foreach ($order['client']['contacts'] as $contact) {
                    $clientContacts[] = [
                        'type' => $contact['type'],
                        'value' => $contact['value'],
                    ];
                }
            }

            $result[] = [
                'id' => $order['id'],
                'status' => [
                    'id' => $order['status']['id'],
                    'label' => $order['status']['label'],
                ],
                'priority' => [
                    'id' => $order['priority']['id'],
                    'label' => $order['priority']['label'],
                ],
                'address' => $order['address'],
                'deadline' => Carbon::createFromFormat('Y-m-d H:i:s', $order['deadline'])
                    ->setTimezone('Europe/Moscow')
                    ->toDateTimeString(),
                'created_at' => Carbon::createFromTimestamp((new \DateTime($order['created_at']))->getTimestamp())
                    ->setTimezone('Europe/Moscow')
                    ->toDateTimeString(),
                'updated_at' => Carbon::createFromTimestamp((new \DateTime($order['updated_at']))->getTimestamp())
                    ->setTimezone('Europe/Moscow')
                    ->toDateTimeString(),
                'comments' => $order['comments'],
                'user' => [
                    'id' => $order['user']['id'],
                    'name' => $order['user']['first_name'] . ' ' . $order['user']['last_name'],
                ],
                'client' => [
                    'id' => $order['client']['id'],
                    'name' => $order['client']['name'],
                    'contacts' => $clientContacts,
                ],
            ];
        }

        return $result;
    }

    public static function getUserOrders(int $userId): array
    {
        $user = User::where('id', $userId)->first();
        $orders = [];
        if ($user) {
            $orders = $user->orders->with(
                [
                    'status' => function (Builder $query) {
                        $query->where('order_statuses.id', 'in', OrderStatus::FOR_CURRENT_USER);
                    },
                    'comments',
                ])->get()->toArray;
        }

        return $orders;
    }

    public static function update(OrderRequest $request): bool
    {
        if (empty($request->id)) {
            return false;
        }

        $order = Order::where('id', $request->id)->first();
        if (!$order) {
            return false;
        }

        if (!empty($request->userId)) {
            $order->user_id = $request->userId;
        }

        if (!empty($request->statusId)) {
            $order->status_id = $request->statusId;
        }

        return $order->save();
    }

    public static function addComment(int $orderId, string $text): bool
    {
        $orderExists = Order::where('id', $orderId)->exists();

        if (!$orderExists || !$text) {
            return false;
        }

        $comment = new OrderComment();
        $comment->order_id = $orderId;
        $comment->text = $text;

        return $comment->save();
    }

    private static function findResponsible(Order $order): ?int
    {
        $masters = UserService::getMasters(true);
        $free = [];
        $inWork = [];

        foreach ($masters as $master) {
            if (!in_array($master['status']['id'], UserStatus::CAN_RECEIVE_ORDERS)
                || empty($master['coordinates'])
            ) {
                continue;
            }

            $tempResult = [];
            $tempResult['distance'] = self::calculateDistance(
                $order->lat,
                $order->lon,
                $master['coordinates']['lat'],
                $master['coordinates']['lon'],
            );
            $tempResult['id'] = $master['id'];
            $tempResult['orders'] = $master['orders'] ?? null;

            if ($master['status']['id'] === UserStatus::FREE) {
                $free[] = $tempResult;
            } else {
                $inWork[] = $tempResult;
            }
        }

        if (!empty($free)) {
            self::sortByDistance($free);
            self::sortByOrdersCount($free);
            $result = $free[0]['id'];
        } elseif (!empty($inWork)) {
            self::sortByDistance($inWork);
            self::sortByOrdersCount($inWork);
            $result = $inWork[0]['id'];
        } else {
            $result = self::DEFAULT_RESPONSIBLE_ID;
        }

        return $result;
    }

    private static function sortByOrdersCount(array &$masters): void
    {
        usort($masters, function ($master1, $master2) {

            $countOrders1 = isset($master1['orders']) ? count($master1['orders']) : 0;
            $countOrders2 = isset($master2['orders']) ? count($master2['orders']) : 0;

            if ($countOrders1 > $countOrders2) {
                return 1;
            } elseif ($countOrders1 < $countOrders2) {
                return -1;
            } else {
                return 0;
            }
        });
    }

    private static function sortByDistance(array &$masters): void
    {
        usort($masters, function($master1, $master2) {
            $delta = abs($master1['distance'] - $master2['distance']);

//                Не учитываем расстояние до 1км
            if ($delta > self::MASTER_DISTANCE_AVAILABLE_DELTA) {
                if ($master1['distance'] > $master2['distance']) {
                    return 1;
                } elseif ($master1['distance'] < $master2['distance']) {
                    return -1;
                }
            } else {
                return 0;
            }
        });
    }

    private static function calculateDistance(
        float $latFrom,
        float $lonFrom,
        float $latTo,
        float $lonTo,
        int $earthRadius = 6371000
    ): float
    {
        $latFromRad = deg2rad($latFrom);
        $lonFromRad = deg2rad($lonFrom);
        $latToRad = deg2rad($latTo);
        $lonToRad = deg2rad($lonTo);

        $latDelta = $latToRad - $latFromRad;
        $lonDelta = $lonToRad - $lonFromRad;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFromRad) * cos($latToRad) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}
