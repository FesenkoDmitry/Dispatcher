<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('entity_id')->nullable(false)->comment('ID сущности')->index();
            $table->enum('entity_type', ['user', 'client'])->nullable(false)->comment('Тип сущности');
            $table->enum('type', ['address', 'phone', 'email'])->nullable(false)->comment('Тип контакта');
            $table->string('value')->nullable(false)->comment('Значение')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
