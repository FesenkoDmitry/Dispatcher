<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')
                ->nullable(false)
                ->comment('ID клиента')
                ->constrained('clients')
                ->restrictOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('order_priority_id')
                ->nullable(false)
                ->comment('ID приоритета')
                ->constrained('order_priorities')
                ->restrictOnUpdate()
                ->restrictOnDelete();
            $table->decimal('lat', 2, 6)->nullable(false)->comment('Широта');
            $table->decimal('lon', 2, 6)->nullable(false)->comment('Долгота');
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
        Schema::dropIfExists('orders');
    }
}
