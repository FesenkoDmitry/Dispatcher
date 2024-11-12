<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersUsersRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_users_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable(false)
                ->comment('ID пользователя')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('order_id')
                ->nullable(false)
                ->comment('ID заказа')
                ->constrained('orders')
                ->cascadeOnDelete();
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
        Schema::dropIfExists('orders_users_relations');
    }
}
