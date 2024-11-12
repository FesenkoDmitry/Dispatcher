<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    const FREE = 1;
    const ON_WAY = 2;
    const WORKING = 3;
    const DAY_OFF = 4;
    const STAGING = 5;

    const CAN_RECEIVE_ORDERS = [
        self::FREE,
        self::WORKING,
    ];

    protected $table = 'user_statuses';
}
