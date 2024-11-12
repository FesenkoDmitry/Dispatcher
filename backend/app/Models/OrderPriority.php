<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OrderPriority extends Model
{
    const BASIC = 2;
    const URGENT = 1;

    protected $table = 'order_priorities';
}
