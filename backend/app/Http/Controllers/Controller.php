<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function login(Request $request)
    {
        $user = User::where(
            [
                'login' => $request->input('login'),
            ]
        )->firstOrFail(['first_name', 'last_name', 'token', 'password']);

        if ($user && Hash::check($request->input('password'), $user->password)) {
            return $user;
        } else {
            return 'Пользователь не найден';
        }
    }
}
