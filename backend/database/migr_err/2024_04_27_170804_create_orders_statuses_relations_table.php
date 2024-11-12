<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersStatusesRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_statuses_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->nullable('false')
                ->comment('ID заказа')
                ->constrained('orders')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('order_status_id')
                ->nullable(false)
                ->comment('ID статуса')
                ->constrained('order_statuses')
                ->restrictOnUpdate()
                ->restrictOnDelete();
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
        Schema::dropIfExists('orders_statuses_relations');
    }
}
