<?php
namespace Database\Seeders;

use App\Models\NewsCategory;
use Illuminate\Database\Seeder;

class NewsCategorySeeder extends Seeder
{
    public function run(): void
    {
        $cats = [
            ['slug' => 'klubnyt', 'name_da' => 'Klubnyt', 'name_en' => 'Club News'],
            ['slug' => 'fodbold', 'name_da' => 'Fodbold', 'name_en' => 'Football'],
            ['slug' => 'haandbold', 'name_da' => 'Håndbold', 'name_en' => 'Handball'],
            ['slug' => 'arrangementer', 'name_da' => 'Arrangementer', 'name_en' => 'Events'],
        ];
        foreach ($cats as $c) { NewsCategory::create($c); }
    }
}
