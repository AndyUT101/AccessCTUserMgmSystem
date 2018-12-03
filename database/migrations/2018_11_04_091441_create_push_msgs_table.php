<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushMsgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_msgs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('msgtpl_id');
            $table->unsignedInteger('user_id');
            $table->json('parameters');
            $table->unsignedTinyInteger('tg_sent')->default(0);
            $table->unsignedTinyInteger('mail_sent')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('push_msgs');
    }
}
