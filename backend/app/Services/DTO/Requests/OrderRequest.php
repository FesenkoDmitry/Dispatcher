<?php

namespace App\Services\DTO\Requests;

use App\Services\DTO\BaseDTO;
use Carbon\Carbon;

class OrderRequest extends BaseDTO
{
    /**
     * @var int|int[]|null
     */
    public $id;
    /**
     * @var int|int[]|null
     */
    public $clientId;
    /**
     * @var int|int[]|null
     */
    public $statusId;
    /**
     * @var int|int[]|null
     */
    public $userId;
    /**
     * @var int|null
     */
    public ?int $orderPriorityId;
    /**
     * @var int|null
     */
    public ?int $deadlineTo;
    /**
     * @var int|null
     */
    public ?int $deadlineFrom;
    /**
     * @var int|null
     */
    public ?int $createdTo;
    /**
     * @var int|null
     */
    public ?int $createdFrom;
    /**
     * @var int|null
     */
    public ?int $updatedTo;
    /**
     * @var int|null
     */
    public ?int $updatedFrom;

    public int $limit = 20;
    public int $offset = 0;

    public function buildConditions(): array
    {
        $result = [];

        if (!empty($this->id)) {
            if (is_array($this->id)) {
                $result['whereIn'][] = ['id', $this->id];
            } else {
                $result['where'][] = ['id', $this->id];
            }
        }

        if (!empty($this->statusId)) {
            if (is_array($this->statusId)) {
                $result['whereIn'][] = ['status_id', $this->statusId];
            } else {
                $result['where'][] = ['status_id', $this->statusId];
            }
        }

        if (!empty($this->userId)) {
            if (is_array($this->userId)) {
                $result['whereIn'][] = ['user_id', $this->userId];
            } else {
                $result['where'][] = ['user_id', $this->userId];
            }
        }

        if (!empty($this->orderPriorityId)) {
            if (is_array($this->userId)) {
                $result['whereIn'][] = ['order_priority_id', $this->orderPriorityId];
            } else {
                $result['where'][] = ['order_priority_id', $this->orderPriorityId];
            }
        }

        if (!empty($this->createdFrom)) {
            $dateTimeString = Carbon::createFromTimestampMs($this->createdFrom)->toDateString();
            $result['where'] = ['created_at', '>=', $dateTimeString];
        }

        if (!empty($this->createdTo)) {
            $dateTimeString = Carbon::createFromTimestampMs($this->createdTo)->toDateString();
            $result['where'] = ['created_at', '<=', $dateTimeString];
        }

        if (!empty($this->deadlineFrom)) {
            $dateTimeString = Carbon::createFromTimestampMs($this->deadlineFrom)->toDateString();
            $result['where'] = ['deadline', '>=', $dateTimeString];
        }

        if (!empty($this->deadlineTo)) {
            $dateTimeString = Carbon::createFromTimestampMs($this->deadlineTo)->toDateString();
            $result['where'] = ['deadline', '<=', $dateTimeString];
        }

        return $result;
    }
}
