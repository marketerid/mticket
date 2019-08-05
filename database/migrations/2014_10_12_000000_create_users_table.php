<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('active_order_id')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable()->unique();
            $table->text('admin_note')->nullable();
            $table->string('password');
            $table->string('utm');
            $table->rememberToken();
            $table->decimal('sms_balance',14)->default(0);
            $table->timestamp('activated')->nullable();
            $table->integer('activate_attempt')->default(1);
            $table->integer('activate_resend_attempt')->default(1);
            $table->string('activate_code')->default('');
            $table->timestamp('activate_code_expired')->nullable();
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
        Schema::dropIfExists('users');
    }
}
