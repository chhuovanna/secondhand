<?php

use Illuminate\Database\Seeder;

/**
 * Class AboutTableSeeder.
 */
class SellerTableSeeder extends Seeder
{
    use  TruncateTable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //App\Seller::truncate();
        DB::table('seller')->insert([
            "name" => "Admin Seller"
            ,'phone' => '012345678'
            ,'email' => 'shop@gmail.com'
            ,'message_account' => 'shop@gmail.com'
            ,'address' => '#123, st. 45, Phnom Penh, Cambodia'
            ,'type' => 'Individual'
            ,'user_id' => '1'
        ]);
    }
}
