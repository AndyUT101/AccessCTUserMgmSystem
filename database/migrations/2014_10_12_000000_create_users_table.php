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
            $table->string('name')->unique();
            $table->string('uuid')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('first_name')->default('');
            $table->string('last_name')->default('');
            $table->unsignedInteger('branchdept_id')->nullable()->default(null);
            $table->unsignedInteger('usertype_id')->nullable()->default(null);
            $table->string('tg_usertoken')->nullable()->default(null);
            $table->string('2fa_token')->nullable()->default(null);
            $table->unsignedTinyInteger('is_disable')->default(0);
            $table->timestamp('last_login')->nullable();
            $table->softDeletes();
            $table->rememberToken();
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
