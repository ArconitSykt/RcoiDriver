<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date')->comment('Дата')->nullable($value = true);
            $table->bigInteger('start_odd')->comment('Стартовый пробег');
            $table->bigInteger('end_odd')->comment('Конечный пробег');
            $table->double('fuel', 8, 3)->comment('Топлива при старте');
            $table->double('fueling', 8, 3)->comment('Заправка');
            $table->double('waiting', 8, 3)->comment('Часов ожидания');
            $table->boolean('check')->comment('Подписан');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fuels');
    }
}