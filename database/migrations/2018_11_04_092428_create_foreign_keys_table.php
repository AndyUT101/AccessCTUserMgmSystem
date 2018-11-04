<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) 
        {
            $table->foreign('branchdept_id')->references('id')->on('branch_depts');
            $table->foreign('usertype_id')->references('id')->on('user_types');
        });
        
        Schema::table('branch_depts', function (Blueprint $table) 
        {
            $table->foreign('zone_id')->references('id')->on('zones');
        });
        
        Schema::table('user_msgs', function (Blueprint $table) 
        {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('msgtpl_id')->references('id')->on('msg_templates');
        });
        
        Schema::table('push_msgs', function (Blueprint $table) 
        {
            $table->foreign('msgtpl_id')->references('id')->on('msg_templates');
        });
        
        Schema::table('access_statuses', function (Blueprint $table) 
        {
            $table->foreign('svcequipitem_id')->references('id')->on('svc_equip_items');
        });
        
        Schema::table('svc_equip_items', function (Blueprint $table) 
        {
            $table->foreign('svc_equip_id')->references('id')->on('svc_equips');
            $table->foreign('item_category_id')->references('id')->on('svc_equip_categories');
        });
        
        Schema::table('svc_equips', function (Blueprint $table) 
        {
            $table->foreign('svc_equiptype_id')->references('id')->on('svc_equip_types');
        });
        
        Schema::table('exec_trays', function (Blueprint $table) 
        {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('acsstatus_id')->references('id')->on('access_statuses');
        });
        
        Schema::table('activities', function (Blueprint $table) 
        {
            $table->foreign('user_id')->references('id')->on('users');
        });  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) 
        {
            $table->dropForeign(['branchdept_id']);
            $table->dropForeign(['usertype_id']);
        });
        
        Schema::table('branch_depts', function (Blueprint $table) 
        {
            $table->dropForeign(['zone_id']);
        });
        
        Schema::table('user_msgs', function (Blueprint $table) 
        {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['msgtpl_id']);
        });
        
        Schema::table('push_msgs', function (Blueprint $table) 
        {
            $table->dropForeign(['msgtpl_id']);
        });
        
        Schema::table('access_statuses', function (Blueprint $table) 
        {
            $table->dropForeign(['svcequipitem_id']);
        });
        
        Schema::table('svc_equip_items', function (Blueprint $table) 
        {
            $table->dropForeign(['svc_equip_id']);
            $table->dropForeign(['item_category_id']);
        });
        
        Schema::table('svc_equips', function (Blueprint $table) 
        {
            $table->dropForeign(['svc_equiptype_id']);
        });
        
        Schema::table('exec_trays', function (Blueprint $table) 
        {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['acsstatus_id']);
        });
        
        Schema::table('activities', function (Blueprint $table) 
        {
            $table->dropForeign(['user_id']);
        });        
    }
}
