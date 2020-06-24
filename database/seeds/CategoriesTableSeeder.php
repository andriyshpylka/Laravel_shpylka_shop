<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
        ['name'=>'Мобильные телефоны','code'=>'mobiles','description'=>'Описание мобильных'],
        ['name'=>'Портативная техника','code'=>'portable','description'=>'Описание портатиной техники'],
        ['name'=>'Кухонная техника','code'=>'technics','description'=>'Описание кухонной техники.'],
    ]);
    }
}
