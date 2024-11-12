<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCoordinatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_coordinates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable(false)
                ->comment('ID пользователя')
                ->unique()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->decimal('lat', 2, 6)
                ->nullable(false)
                ->comment('Широта');
            $table->decimal('lon', 2, 6)
                ->nullable(false)
                ->comment('Долгота');
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
        Schema::dropIfExists('user_coordinates');
    }
}
