<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    const ADMIN = 1;
    const MASTER = 2;
    const USER = 3;

    protected $table = 'user_roles';

}
