<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSvcEquipItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('svc_equip_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('svc_equip_id');
            $table->unsignedInteger('item_category_id');
            $table->string('name');
            $table->text('desc');
            $table->text('exec_command');
            $table->json('require_parameters');
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
        Schema::dropIfExists('svc_equip_items');
    }
}
