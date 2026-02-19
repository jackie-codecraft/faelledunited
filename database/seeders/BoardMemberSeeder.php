<?php

namespace Database\Seeders;

use App\Models\BoardMember;
use Illuminate\Database\Seeder;

class BoardMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'name'       => 'Mette Andersen',
                'role_da'    => 'Formand',
                'role_en'    => 'Chairperson',
                'bio_da'     => 'Mette har været frivillig i Fælled United siden 2018 og har siden 2022 ledet klubben som formand.',
                'bio_en'     => 'Mette has been a volunteer at Fælled United since 2018.',
                'sort_order' => 1,
                'is_active'  => true,
            ],
            [
                'name'       => 'Kasper Jensen',
                'role_da'    => 'Næstformand & Fodboldkoordinator',
                'role_en'    => 'Vice-Chair & Football Coordinator',
                'bio_da'     => 'Kasper koordinerer al fodboldaktivitet i klubben og er far til to af vores spillere.',
                'bio_en'     => 'Kasper coordinates all football activities in the club.',
                'sort_order' => 2,
                'is_active'  => true,
            ],
            [
                'name'       => 'Sara Christensen',
                'role_da'    => 'Kasserer',
                'role_en'    => 'Treasurer',
                'bio_da'     => 'Sara holder styr på klubbens økonomi og sørger for, at alt går op i en højere enhed.',
                'bio_en'     => 'Sara manages the club finances.',
                'sort_order' => 3,
                'is_active'  => true,
            ],
            [
                'name'       => 'Lars Møller',
                'role_da'    => 'Håndboldkoordinator',
                'role_en'    => 'Handball Coordinator',
                'bio_da'     => 'Lars er ved at opbygge vores nye håndboldafdeling og søger gerne samarbejdspartnere.',
                'bio_en'     => 'Lars is building our new handball department.',
                'sort_order' => 4,
                'is_active'  => true,
            ],
        ];

        foreach ($members as $member) {
            BoardMember::create($member);
        }
    }
}
