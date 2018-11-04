<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchDeptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_depts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('desc');
            $table->enum('type', ['branch', 'dept']);
            $table->unsignedTinyInteger('code');
            $table->unsignedInteger('zone_id')->nullable()->default(null);
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
        Schema::dropIfExists('branch_depts');
    }
}
