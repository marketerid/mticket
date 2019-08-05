<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCsRotatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cs_rotate', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->integer('user_id');
            $table->string('type'); // landing page, product detail, checkout form, payment, thank you
            $table->string('title');
            $table->string('api_key');
            $table->text('message')->nullable();
            $table->text('javascript')->nullable();

            $table->string('google_analytic');
            $table->string('facebook_pixel_id');
            $table->string('facebook_pixel_event');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cs_rotate_sub', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cs_rotate_id');
            $table->string('phone');
            $table->string('name');
            $table->string('avatar');
            $table->decimal('percentage',12);
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cs_rotate_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token');
            $table->string('event');
            $table->integer('cs_rotate_id');
            $table->string('phone');
            $table->string('name');
            $table->text('message')->nullable();
            $table->string('campaign');
            $table->string('client_ip');
            $table->string('client_browser');
            $table->timestamps();
        });

        Schema::create('cs_rotate_schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cs_rotate_id');
            $table->integer('cs_rotate_sub_id');

            $table->boolean('is_active')->default(true);

            $table->string('type'); // weekly/custom
            $table->string('start_day');
            $table->string('to_day');

            $table->time('start_hour')->nullable();
            $table->time('to_hour')->nullable();

            $table->timestamp('start_custom');
            $table->timestamp('to_custom');


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
