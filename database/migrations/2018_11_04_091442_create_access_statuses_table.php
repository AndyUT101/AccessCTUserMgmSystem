<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('svcequipitem_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('status');
            $table->unsignedTinyInteger('is_pending')->default(1);
            $table->dateTime('request_enddate');
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
        Schema::dropIfExists('access_statuses');
    }
}
