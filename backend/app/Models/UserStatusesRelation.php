<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserStatusesRelation extends Model
{
    protected $table = 'users_statuses_relations';

    public function status(): HasOne
    {
        return $this->hasOne(UserStatus::class, 'id', 'user_status_id');
    }
}
