<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    const ENTITY_TYPE_USER = 'user';
    const ENTITY_TYPE_CLIENT = 'client';

    const TYPE_ADDRESS = 'address';
    const TYPE_PHONE = 'phone';
    const TYPE_EMAIL = 'email';

    protected $guarded = ['id'];
}
