<?php

namespace Database\Seeders;

use App\Models\AgeGroup;
use App\Models\Department;
use Illuminate\Database\Seeder;

class AgeGroupSeeder extends Seeder
{
    public function run(): void
    {
        $fodbold   = Department::where('slug', 'fodbold')->first();
        $haandbold = Department::where('slug', 'haandbold')->first();

        $fodboldGroups = [
            [
                'slug'              => '2010-drenge',
                'label_da'          => '2010 Drenge',
                'label_en'          => '2010 Boys',
                'birth_year'        => 2010,
                'gender'            => 'boys',
                'description_da'    => 'Vores U15-drenge er et stærkt hold med god erfaring og en stor passion for fodbold. Hold er åbent for drenge født i 2010 og tilbyder konkurrencepræget træning med fokus på taktik og teknisk udvikling.',
                'description_en'    => 'Our U15 boys are a strong team with great experience and a passion for football. The team is open to boys born in 2010 and offers competitive training with a focus on tactics and technical development.',
                'training_schedule' => ['days' => 'Tirsdag & Torsdag', 'time' => '16:30 – 18:00', 'location' => 'Fælledparken bane 2'],
                'coach_info'        => ['name' => 'Martin Christensen', 'email' => 'martin@faelledunited.dk', 'phone' => '28 11 22 33'],
            ],
            [
                'slug'              => '2011-drenge',
                'label_da'          => '2011 Drenge',
                'label_en'          => '2011 Boys',
                'birth_year'        => 2011,
                'gender'            => 'boys',
                'description_da'    => 'U14-drenge med stor energi og godt sammenhold. Vi træner to gange ugentligt og spiller i DBU Københavns rækker. Alle niveauer er velkomne.',
                'description_en'    => 'U14 boys with great energy and team spirit. We train twice a week and play in the DBU Copenhagen leagues. All levels welcome.',
                'training_schedule' => ['days' => 'Mandag & Onsdag', 'time' => '16:30 – 18:00', 'location' => 'Fælledparken bane 3'],
                'coach_info'        => ['name' => 'Lars Jensen', 'email' => 'lars@faelledunited.dk', 'phone' => '40 33 22 11'],
            ],
            [
                'slug'              => '2012-drenge',
                'label_da'          => '2012 Drenge',
                'label_en'          => '2012 Boys',
                'birth_year'        => 2012,
                'gender'            => 'boys',
                'description_da'    => 'U13-drenge der er ved at finde deres fodboldrytme. Her handler det om sjov, fairplay og teknisk udvikling i et trygt miljø.',
                'description_en'    => 'U13 boys finding their football rhythm. Here it is about fun, fair play and technical development in a safe environment.',
                'training_schedule' => ['days' => 'Tirsdag & Torsdag', 'time' => '15:30 – 17:00', 'location' => 'Fælledparken bane 4'],
                'coach_info'        => ['name' => 'Søren Nielsen', 'email' => 'soeren@faelledunited.dk', 'phone' => '50 44 33 22'],
            ],
            [
                'slug'              => '2012-piger',
                'label_da'          => '2012 Piger',
                'label_en'          => '2012 Girls',
                'birth_year'        => 2012,
                'gender'            => 'girls',
                'description_da'    => 'Pigernes U13-hold er et aktivt og livligt hold med stor passion for fodbold. Vi fokuserer på teknisk udvikling, sammenhold og glæde ved spillet.',
                'description_en'    => 'The girls U13 team is an active and lively team with great passion for football. We focus on technical development, teamwork and joy of the game.',
                'training_schedule' => ['days' => 'Mandag & Fredag', 'time' => '15:30 – 17:00', 'location' => 'Fælledparken bane 5'],
                'coach_info'        => ['name' => 'Camilla Petersen', 'email' => 'camilla@faelledunited.dk', 'phone' => '31 22 11 00'],
            ],
            [
                'slug'              => '2013-mixed',
                'label_da'          => '2013 Piger & Drenge',
                'label_en'          => '2013 Girls & Boys',
                'birth_year'        => 2013,
                'gender'            => 'mixed',
                'description_da'    => 'Vores mixed U12-hold er for alle, der vil prøve kræfter med fodbold. Hold er mixed, og vi lægger stor vægt på inklusion, leg og læring.',
                'description_en'    => 'Our mixed U12 team is for everyone who wants to try football. The team is mixed, and we place great emphasis on inclusion, play and learning.',
                'training_schedule' => ['days' => 'Onsdag & Fredag', 'time' => '15:00 – 16:30', 'location' => 'Fælledparken bane 6'],
                'coach_info'        => ['name' => 'Thomas Hansen', 'email' => 'thomas@faelledunited.dk'],
            ],
            [
                'slug'              => '2014-piger',
                'label_da'          => '2014 Piger',
                'label_en'          => '2014 Girls',
                'birth_year'        => 2014,
                'gender'            => 'girls',
                'description_da'    => 'U11-piger med masser af energi og glæde ved fodbold. Træningen er legebåret og fokuserer på grundlæggende tekniske færdigheder.',
                'description_en'    => 'U11 girls with lots of energy and joy of football. Training is play-based and focuses on fundamental technical skills.',
                'training_schedule' => ['days' => 'Tirsdag & Torsdag', 'time' => '15:00 – 16:30', 'location' => 'Fælledparken bane 7'],
                'coach_info'        => ['name' => 'Emma Larsen', 'email' => 'emma@faelledunited.dk'],
            ],
            [
                'slug'              => '2015-piger',
                'label_da'          => '2015 Piger',
                'label_en'          => '2015 Girls',
                'birth_year'        => 2015,
                'gender'            => 'girls',
                'description_da'    => 'For vores yngste pigehold er det vigtigste at have det sjovt. Vi spiller, laver øvelser og bliver bedre sammen — ét mål ad gangen!',
                'description_en'    => 'For our youngest girls team, the most important thing is to have fun. We play, do exercises and get better together — one goal at a time!',
                'training_schedule' => ['days' => 'Onsdag', 'time' => '15:00 – 16:15', 'location' => 'Fælledparken bane 8'],
                'coach_info'        => ['name' => 'Julie Andersen', 'email' => 'julie@faelledunited.dk'],
            ],
            [
                'slug'              => '2016-piger',
                'label_da'          => '2016 Piger',
                'label_en'          => '2016 Girls',
                'birth_year'        => 2016,
                'gender'            => 'girls',
                'description_da'    => 'Nybegynderpiger der tager de første skridt i fodboldens verden. Her er masser af leg, baner og smil — velkommen til alle!',
                'description_en'    => 'Beginner girls taking their first steps in the world of football. Lots of play, pitches and smiles here — welcome to all!',
                'training_schedule' => ['days' => 'Torsdag', 'time' => '14:30 – 15:45', 'location' => 'Fælledparken bane 9'],
                'coach_info'        => ['name' => 'Anna Møller', 'email' => 'anna@faelledunited.dk'],
            ],
            [
                'slug'              => '2017-piger',
                'label_da'          => '2017 Piger',
                'label_en'          => '2017 Girls',
                'birth_year'        => 2017,
                'gender'            => 'girls',
                'description_da'    => 'Vores yngste pigehold er for de allersmå sportsglad piger. Træningen er legebåret og foregår i et trygt, sjovt miljø.',
                'description_en'    => 'Our youngest girls team is for the very young sports-loving girls. Training is play-based and takes place in a safe, fun environment.',
                'training_schedule' => ['days' => 'Fredag', 'time' => '14:00 – 15:00', 'location' => 'Fælledparken bane 10'],
                'coach_info'        => ['name' => 'Sara Thomsen', 'email' => 'sara@faelledunited.dk'],
            ],
            [
                'slug'              => '2018-2019-piger',
                'label_da'          => '2018 & 2019 Piger',
                'label_en'          => '2018 & 2019 Girls',
                'birth_year'        => 2018,
                'gender'            => 'girls',
                'description_da'    => 'For vores allermindste piger er det vigtigste bare at bevæge sig og have det godt. Kom og se, hvad fodbold handler om — der er plads til alle!',
                'description_en'    => 'For our very youngest girls the most important thing is to move and feel good. Come and see what football is about — there is room for everyone!',
                'training_schedule' => ['days' => 'Lørdag', 'time' => '10:00 – 11:00', 'location' => 'Fælledparken bane 1 (minibane)'],
                'coach_info'        => ['name' => 'Mette Skov', 'email' => 'mette@faelledunited.dk'],
            ],
            [
                'slug'              => '2013-2020-mixed',
                'label_da'          => '2013–2020 Mixed',
                'label_en'          => '2013–2020 Mixed',
                'birth_year'        => 2013,
                'gender'            => 'mixed',
                'description_da'    => 'Åbent mixed-hold for alle årgange fra 2013 til 2020. Perfekt for børn der gerne vil prøve fodbold uden forpligtelse. Alle er velkomne!',
                'description_en'    => 'Open mixed team for all year groups from 2013 to 2020. Perfect for children who want to try football without commitment. All are welcome!',
                'training_schedule' => ['days' => 'Lørdag', 'time' => '11:00 – 12:30', 'location' => 'Fælledparken bane 2', 'notes' => 'Sæsonstart marts – ingen tilmelding nødvendig'],
                'coach_info'        => ['name' => 'Kasper Dahl', 'email' => 'kasper@faelledunited.dk', 'phone' => '61 55 44 33'],
            ],
        ];

        foreach ($fodboldGroups as $i => $g) {
            AgeGroup::updateOrCreate(
                ['department_id' => $fodbold->id, 'slug' => $g['slug']],
                array_merge($g, [
                    'department_id' => $fodbold->id,
                    'sort_order'    => $i + 1,
                    'is_active'     => true,
                ])
            );
        }

        // Håndbold
        AgeGroup::updateOrCreate(
            ['department_id' => $haandbold->id, 'slug' => 'haandbold-alle'],
            [
                'department_id'     => $haandbold->id,
                'slug'              => 'haandbold-alle',
                'label_da'          => 'Alle årgange (åbent hold)',
                'label_en'          => 'All ages (open team)',
                'birth_year'        => null,
                'gender'            => 'mixed',
                'description_da'    => 'Vores håndboldafdeling er stadig ny, og vi samler alle interesserede i ét åbent hold. Er du og dit barn interesseret i håndbold? Kom og vær med fra starten!',
                'description_en'    => 'Our handball department is still new, and we gather all interested in one open team. Are you and your child interested in handball? Come and be part of it from the start!',
                'training_schedule' => ['days' => 'Lørdag', 'time' => '10:00 – 12:00', 'location' => 'Nørrebrohallen — sal B', 'notes' => 'Sæsonstart september – hold øje med nyheder'],
                'coach_info'        => ['name' => 'Rasmus Holm', 'email' => 'rasmus@faelledunited.dk', 'phone' => '29 77 66 55'],
                'sort_order'        => 1,
                'is_active'         => true,
            ]
        );
    }
}
