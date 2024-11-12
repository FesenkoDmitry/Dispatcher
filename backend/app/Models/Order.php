<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    const DEFAULT_RESPONSIBLE_USER_ID = 1;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(OrderComment::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(OrderPriority::class, 'order_priority_id');
    }
}
