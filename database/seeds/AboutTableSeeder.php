<?php

use Illuminate\Database\Seeder;

/**
 * Class AboutTableSeeder.
 */
class AboutTableSeeder extends Seeder
{
    use  TruncateTable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\About::truncate();
        DB::table('about')->insert([
            'phone' => '012345678'
            ,'email' => 'shop@gmail.com'
            ,'website' => 'www.shop.com'
            ,'address' => '#123, st. 45, Phnom Penh, Cambodia'
        ]);
    }
}
