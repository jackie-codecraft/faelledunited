<?php
namespace Database\Seeders;

use App\Models\AgeGroup;
use App\Models\Department;
use Illuminate\Database\Seeder;

class AgeGroupSeeder extends Seeder
{
    public function run(): void
    {
        $fodbold = Department::where('slug', 'fodbold')->first();
        $groups = [
            ['slug' => '2010-drenge', 'label_da' => '2010 Drenge', 'label_en' => '2010 Boys', 'birth_year' => 2010, 'gender' => 'boys'],
            ['slug' => '2011-drenge', 'label_da' => '2011 Drenge', 'label_en' => '2011 Boys', 'birth_year' => 2011, 'gender' => 'boys'],
            ['slug' => '2012-drenge', 'label_da' => '2012 Drenge', 'label_en' => '2012 Boys', 'birth_year' => 2012, 'gender' => 'boys'],
            ['slug' => '2012-piger', 'label_da' => '2012 Piger', 'label_en' => '2012 Girls', 'birth_year' => 2012, 'gender' => 'girls'],
            ['slug' => '2013-mixed', 'label_da' => '2013 Piger & Drenge', 'label_en' => '2013 Girls & Boys', 'birth_year' => 2013, 'gender' => 'mixed'],
            ['slug' => '2014-piger', 'label_da' => '2014 Piger', 'label_en' => '2014 Girls', 'birth_year' => 2014, 'gender' => 'girls'],
            ['slug' => '2015-piger', 'label_da' => '2015 Piger', 'label_en' => '2015 Girls', 'birth_year' => 2015, 'gender' => 'girls'],
            ['slug' => '2016-piger', 'label_da' => '2016 Piger', 'label_en' => '2016 Girls', 'birth_year' => 2016, 'gender' => 'girls'],
            ['slug' => '2017-piger', 'label_da' => '2017 Piger', 'label_en' => '2017 Girls', 'birth_year' => 2017, 'gender' => 'girls'],
            ['slug' => '2018-2019-piger', 'label_da' => '2018 & 2019 Piger', 'label_en' => '2018 & 2019 Girls', 'birth_year' => 2018, 'gender' => 'girls'],
        ];
        foreach ($groups as $i => $g) {
            AgeGroup::create(array_merge($g, ['department_id' => $fodbold->id, 'sort_order' => $i + 1]));
        }
    }
}
