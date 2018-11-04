<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTypeSvcEquipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_type_svc_equips', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_type_id');
            $table->unsignedInteger('svc_equip_id');
            $table->unsignedTinyInteger('accept_notify')->default(0);
            $table->unsignedTinyInteger('approve_right')->default(0);
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
        Schema::dropIfExists('user_type_svc_equips');
    }
}
