<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserRole;
use App\Services\DTO\UserDTO;
use Carbon\Carbon;

class UserService
{
    public static function getMasters(bool $withOrders = false): array
    {
        $with = [
            'status' => function ($query) {
                $query->select('user_statuses.id', 'user_statuses.name', 'user_statuses.label');
            },
            'coordinates',
        ];

        if ($withOrders) {
            $with['orders'] = function ($query) {
                $query->whereDate('orders.created_at', Carbon::now()->toDateString());
            };
        }

        $masters = User::whereHas('roles', function ($query) {
            return $query->where('user_roles.id', UserRole::MASTER);
        })
            ->select('id', 'first_name', 'last_name', 'status_id')
            ->with($with)
            ->get()
            ->toArray();

        foreach ($masters as &$master) {
            $coords = $master['coordinates'];
            $master['address'] = null;
            if ($coords) {
                $addressSuggestions = DadataService::geoLocate($coords['lat'], $coords['lon']);
                $master['address'] = $addressSuggestions[0]['value'] ?? null;
            }
        }


        return $masters;
    }

    public static function update(UserDTO $userDto): bool
    {
        $user = User::where('id', $userDto->id)->first();
        $result = false;

        if ($user) {
            if (isset($userDto->statusId)) {
                $user->status_id = $userDto->statusId;
            }

            if (isset($userDto->firstName)) {
                $user->first_name = $userDto->firstName;
            }

            if (isset($userDto->lastName)) {
                $user->last_name = $userDto->lastName;
            }

            $result = $user->save();
        }

        return $result;
    }

    public static function setStatus(UserDTO $userDto): bool
    {
        $user = User::where('id', $userDto->id)->first();
        $result = false;

        if ($user && !empty($userDto->statusId)) {
            $user->status_id = $userDto->statusId;
            $result = $user->save();
        }

        return $result;
    }

    public static function getStatus(int $userId): array
    {
        $user = User::where('id', $userId)->first();
        return $user->status->toArray();
    }
}
