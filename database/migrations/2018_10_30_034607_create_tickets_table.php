<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->mediumText('content');
            $table->string('slug')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('user_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->timestamps();
            $table->dateTime('solved_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
