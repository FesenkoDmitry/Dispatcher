<?php


namespace App\Http\Controllers;


use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use App\Models\UserStatus;
use App\Services\DTO\UserDTO;
use App\Services\OrderService;
use App\Services\UserService;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function statuses(): array
    {
        $this->authorize('admin', User::class);

        return UserStatus::select('id', 'name', 'label')->get()->toArray();
    }

    public function masters(): array
    {
        $this->authorize('admin', User::class);

        return UserService::getMasters();
    }

    public function update(Request $request): bool
    {
        $this->authorize('admin', User::class);

        $userDto = new UserDTO();
        $userDto->parseFromRequest($request);

        return UserService::update($userDto);
    }

    public function setStatus(Request $request): bool
    {
        $this->authorize('master', User::class);

        $userDto = new UserDTO();
        $userDto->parseFromRequest($request);

        if (empty($request->input('id'))) {
            $userDto->id = Auth::id();
        }

        var_dump($userDto);

        return UserService::update($userDto);
    }

    public function getStatus(): array
    {
        $this->authorize('master', User::class);

        return UserService::getStatus(Auth::id());
    }
}
