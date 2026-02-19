<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        Department::create([
            'slug'           => 'fodbold',
            'name_da'        => 'Fodbold',
            'name_en'        => 'Football',
            'description_da' => 'Fælled Uniteds fodboldafdeling tilbyder træning for piger og drenge fra de mindste årgange op til ungdomshold. Vi træner på Fælledparkens baner og har hold for næsten alle årgange. Hos os handler det om at have det sjovt, lære spillet og skabe stærke venskaber.',
            'description_en' => 'Fælled United\'s football department offers training for boys and girls from the youngest age groups up to youth teams.',
            'sort_order'     => 1,
            'is_active'      => true,
        ]);

        Department::create([
            'slug'           => 'haandbold',
            'name_da'        => 'Håndbold',
            'name_en'        => 'Handball',
            'description_da' => 'Vores håndboldafdeling er ny og vi er ved at bygge den op fra bunden. Vi søger trænere og spillere til alle årgange. Har du lyst til at være med fra starten og forme fremtidens hold? Tilmeld dig allerede nu, og vi kontakter dig, når vi er klar til opstart.',
            'description_en' => 'Our handball department is new and we are building it from the ground up.',
            'sort_order'     => 2,
            'is_active'      => true,
        ]);
    }
}
