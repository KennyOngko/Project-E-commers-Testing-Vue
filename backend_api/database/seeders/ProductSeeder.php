<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            ["categoriesID"=>1,"productName"=>'Baju White', "qty"=>10,'price'=>50000,'gambar'=>'http://127.0.0.1:8000/storage/Img/baju1.jpg','description'=>'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quasi animi, corporis esse modi sapiente nostrum possimus cum similique quia perferendis, consequuntur doloremque rem! Omnis, excepturi possimus tempore provident eum beatae!'],
            ["categoriesID"=>1,"productName"=>'Baju hitam', "qty"=>10,'price'=>60000,'gambar'=>'http://127.0.0.1:8000/storage/Img/baju1.jpg','description'=>'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quasi animi, corporis esse modi sapiente nostrum possimus cum similique quia perferendis, consequuntur doloremque rem! Omnis, excepturi possimus tempore provident eum beatae!'],
            ["categoriesID"=>1,"productName"=>'Baju merah', "qty"=>10,'price'=>70000,'gambar'=>'http://127.0.0.1:8000/storage/Img/baju1.jpg','description'=>'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quasi animi, corporis esse modi sapiente nostrum possimus cum similique quia perferendis, consequuntur doloremque rem! Omnis, excepturi possimus tempore provident eum beatae!'],
            ["categoriesID"=>1,"productName"=>'Baju biru', "qty"=>10,'price'=>80000,'gambar'=>'http://127.0.0.1:8000/storage/Img/baju1.jpg' ,'description'=>'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quasi animi, corporis esse modi sapiente nostrum possimus cum similique quia perferendis, consequuntur doloremque rem! Omnis, excepturi possimus tempore provident eum beatae!'],
        ]);
    }
}
