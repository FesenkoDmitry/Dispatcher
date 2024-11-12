<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'entity_id');
    }
}
