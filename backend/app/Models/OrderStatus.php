<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    const CREATED = 1;
    const ACCEPTED = 2;
    const IN_PROGRESS = 3;
    const DONE = 4;
    const CANCELLED = 5;
    const APPOINTED = 6;

    const FOR_CURRENT_USER = [
        self::ACCEPTED,
        self::IN_PROGRESS,
        self::APPOINTED,
    ];

    protected $table = 'order_statuses';
}
