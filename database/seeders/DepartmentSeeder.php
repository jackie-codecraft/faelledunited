<?php
namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        Department::create(['slug' => 'fodbold', 'name_da' => 'Fodbold', 'name_en' => 'Football', 'sort_order' => 1]);
        Department::create(['slug' => 'haandbold', 'name_da' => 'Håndbold', 'name_en' => 'Handball', 'sort_order' => 2]);
    }
}
