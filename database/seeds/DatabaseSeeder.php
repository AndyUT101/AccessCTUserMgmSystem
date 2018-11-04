<?php

use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        /*
         * Users
         */
        $this->insert_zones();
        $this->insert_branch_depts();
        $this->insert_users();


        $this->insert_svc_equip_types();
        $this->insert_svc_equips();
    }

    public function insert_zones(){
        DB::table('zones')->insert([
            'id' => 1,
            'name' => 'Central',
            'desc' => 'Central, Hong Kong',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }   

    public function insert_branch_depts(){
        DB::table('branch_depts')->insert([
            'id' => 1,
            'name' => 'IT Department',
            'desc' => '',
            'type' => 'dept',
            'code' => 01,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('branch_depts')->insert([
            'id' => 2,
            'name' => 'One IFC',
            'desc' => '',
            'type' => 'branch',
            'code' => 01,
            'zone_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }

    public function insert_users(){
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'admin',
            'uuid' => Uuid::generate(4)->string,
            'email' => 'admin@company.com',
            'password' => bcrypt('admin'),
            'branchdept_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('users')->insert([
            'id' => 2,
            'name' => 'b01s01',
            'uuid' => Uuid::generate(4)->string,
            'email' => 'b02s02@company.com',
            'password' => bcrypt('b01s01'),
            'branchdept_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }

    public function insert_svc_equip_types(){
        DB::table('svc_equip_types')->insert([
            'id' => 1,
            'keyname' => 'it-service',
            'name' => 'IT Service',
            'desc' => 'IT Service',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('svc_equip_types')->insert([
            'id' => 2,
            'keyname' => 'comp-equip',
            'name' => 'Computer Equipment (Hardware / Software)',
            'desc' => 'Computer Equipment (Hardware / Software)',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }

    public function insert_svc_equips(){
        DB::table('svc_equips')->insert([
            'id' => 1,
            'keyname' => 'new-program-system',
            'name' => 'New Program / System',
            'desc' => 'New Program / System',
            'svc_equiptype_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('svc_equips')->insert([
            'id' => 2,
            'keyname' => 'desktop-pc',
            'name' => 'Desktop PC',
            'desc' => 'Desktop PC',
            'svc_equiptype_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }

    
}
