<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('source_id');
            $table->string('type');
            $table->string('title');
            $table->text('description');
            $table->string('image');
            $table->string('city');
            $table->integer('price');
            $table->string('event_date');
            $table->string('before_paid_sms');
            $table->string('after_paid_sms');
            $table->text('before_paid_email');
            $table->text('after_paid_email');
            $table->integer('adspend');
            $table->integer('is_full');
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();
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
