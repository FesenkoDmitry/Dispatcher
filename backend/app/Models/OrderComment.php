<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OrderComment extends Model
{
    public function create(int $orderId, string $text): bool
    {

    }
}
