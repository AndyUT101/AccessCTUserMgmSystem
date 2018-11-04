<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppTable extends Migration
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
            $table->string('name')->unique()->change();

            $table->string('uuid')->unique();
            $table->string('first_name')->default('');
            $table->string('last_name')->default('');
            $table->unsignedInteger('branchdept_id')->nullable()->default(null);
            $table->unsignedInteger('usertype_id')->nullable()->default(null);
            $table->string('tg_usertoken')->nullable()->default(null);
            $table->string('2fa_token')->nullable()->default(null);
            $table->unsignedTinyInteger('is_disable')->default(0);
            $table->softDeletes();
        });

        Schema::create('branch_dept', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('desc');
            $table->enum('type', ['branch', 'dept']);
            $table->unsignedTinyInteger('zone_id')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
        });
        
        Schema::create('zone', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('desc');
            $table->softDeletes();
            $table->timestamps();
        });
        
        Schema::create('auth_token', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unique();
            $table->string('2fa_token')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
        });
        
        Schema::create('user_type', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('typelevel');
            $table->softDeletes();
            $table->timestamps();
        });
        
        Schema::create('user_type_svc_equip', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->unsignedInteger('user_type_id');
            $table->unsignedInteger('svc_equip_id');
            $table->unsignedTinyInteger('accept_notify')->default(0);
            $table->unsignedTinyInteger('approve_right')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
        
        Schema::create('msg_template', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('msgkey')->unique();
            $table->text('content');
            $table->softDeletes();
            $table->timestamps();
        });
        
        Schema::create('user_msg', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('msgtpl_id');
            $table->json('parameters');
            $table->unsignedTinyInteger('is_read')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
        
        Schema::create('push_msg', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->unsignedInteger('msgtpl_id');
            $table->unsignedTinyInteger('tg_sent')->default(0);
            $table->unsignedTinyInteger('mail_sent')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
        
        Schema::create('access_status', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->unsignedInteger('svcequipitem_id');
            $table->unsignedInteger('status');
            $table->unsignedTinyInteger('is_pending')->default(1);
            $table->dateTime('request_enddate');
            $table->softDeletes();
            $table->timestamps();
        });
        
        Schema::create('svc_equip_items', function (Blueprint $table) 
        {
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
        
        Schema::create('svc_equip_category', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('name');
            $table->text('desc');
            $table->unsignedInteger('svc_equip_id');
            $table->softDeletes();
            $table->timestamps();
        });
        
        Schema::create('svc_equip', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('name');
            $table->text('desc');
            $table->unsignedInteger('svc_equiptype_id');
            $table->softDeletes();
            $table->timestamps();
        });
        
        Schema::create('svc_equip_type', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('name');
            $table->text('desc');
            $table->softDeletes();
            $table->timestamps();
        });
        
        Schema::create('exec_tray', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('acsstatus_id');
            $table->dateTime('exec_datetime')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
        });
        
        Schema::create('activity', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('activity_key');
            $table->text('activity');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });

        Schema::dropIfExists('branch_dept');
        Schema::dropIfExists('zone');
        Schema::dropIfExists('auth_token');
        Schema::dropIfExists('user_type');
        Schema::dropIfExists('user_type_svc_equip');
        Schema::dropIfExists('msg_template');
        Schema::dropIfExists('user_msg');
        Schema::dropIfExists('push_msg');
        Schema::dropIfExists('access_status');
        Schema::dropIfExists('svc_equip_items');
        Schema::dropIfExists('svc_equip_category');
        Schema::dropIfExists('svc_equip');
        Schema::dropIfExists('svc_equip_type');
        Schema::dropIfExists('exec_tray');
        Schema::dropIfExists('activity');
    }
}
