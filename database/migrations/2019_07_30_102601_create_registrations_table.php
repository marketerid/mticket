<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('city');
            $table->integer('total');
            $table->string('invoice')->unique();
            $table->string('payment');
            $table->string('status_paid');
            $table->string('lang');
            $table->string('session');
            $table->string('reference');
            $table->text('person_dump');
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
        //
    }
}
