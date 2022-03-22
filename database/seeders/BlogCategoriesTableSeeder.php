<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\Console\Style\table;

class BlogCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [];

        $cName = 'Без категории';
        $categories[] = [

            'title' => $cName,
            'slug' => Str::of($cName)->slug(),
            'parent_id' => 0,
        ];

        for ($i = 1; $i <= 10; $i++){
            $cName = 'Категория №'.$i;
            $parentId = ($i > 4) ? rand (1, 4): 1;

            $categories[] = [
                'title' => $cName,
                'slug' => Str::of($cName)->slug(),
                'parent_id' => $parentId,

            ];
        }
            \DB::table('blog_categories')->insert($categories);


    }
}
