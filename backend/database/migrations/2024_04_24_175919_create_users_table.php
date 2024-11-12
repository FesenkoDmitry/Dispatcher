<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable(false)->comment('Имя');
            $table->string('last_name')->nullable(false)->comment('Фамилия');
            $table->string('login')->nullable(false)->comment('Логин')->unique();
            $table->string('password')->nullable(false)->comment('Пароль');
            $table->string('token')->nullable(false)->comment('API токен');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
