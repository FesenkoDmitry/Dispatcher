<?php


namespace App\Http\Controllers;



use App\Models\OrderStatus;
use App\Models\User;
use App\Services\DTO\OrderDTO;
use App\Services\DTO\Requests\OrderRequest;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $orderDto = new OrderDTO();
        $orderDto->parseFromRequest($request);
        $isCreated = OrderService::create($orderDto);
        $response = [
            'success' => $isCreated,
        ];

        return $response;
    }

    public function update(Request $request)
    {
        if (!$request->input('userId')) {
            $this->authorize('master', User::class);
        } else {
            $this->authorize('admin', User::class);
        }

        $orderRequest = new OrderRequest();
        $orderRequest->parseFromRequest($request);

        return OrderService::update($orderRequest);
    }

    public function list(Request $request): array
    {
        $this->authorize('admin', User::class);

        $orderRequest = new OrderRequest();
        $orderRequest->parseFromRequest($request);

        return OrderService::getOrders($orderRequest);
    }

    public function statuses(): array
    {
        $this->authorize('admin', User::class);

        return OrderStatus::select('id', 'name', 'label')->get()->toArray();
    }

    public function currentUser(): array
    {
        $this->authorize('master', User::class);

        $orderRequest = new OrderRequest();
        $orderRequest->userId = Auth::id();
        $orderRequest->statusId = OrderStatus::FOR_CURRENT_USER;

        return OrderService::getOrders($orderRequest);
    }

    public function currentUserHistory(): array
    {
        $this->authorize('master', User::class);

        $orderRequest = new OrderRequest();
        $orderRequest->userId = Auth::id();

        return OrderService::getOrders($orderRequest);
    }

    public function addComment(Request $request): bool
    {
        $this->authorize('master', User::class);

        return OrderService::addComment($request->input('orderId'), $request->input('text'));
    }
}
