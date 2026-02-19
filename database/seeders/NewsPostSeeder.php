<?php

namespace Database\Seeders;

use App\Models\NewsCategory;
use App\Models\NewsPost;
use Illuminate\Database\Seeder;

class NewsPostSeeder extends Seeder
{
    public function run(): void
    {
        $klubnyt       = NewsCategory::where('slug', 'klubnyt')->first();
        $fodbold       = NewsCategory::where('slug', 'fodbold')->first();
        $arrangementer = NewsCategory::where('slug', 'arrangementer')->first();

        $posts = [
            [
                'news_category_id' => $klubnyt->id,
                'slug'             => 'vores-nye-hjemmeside-er-online',
                'title_da'         => 'Vores nye hjemmeside er online!',
                'title_en'         => 'Our new website is online!',
                'excerpt_da'       => 'Vi er glade for at præsentere vores brandnye hjemmeside — bygget af frivillige forældre til hele Fælled United-familien.',
                'excerpt_en'       => 'We are excited to present our brand new website.',
                'body_da'          => "# Vores nye hjemmeside er online!\n\nKære Fælled United-familie,\n\nVi er utrolig stolte over at præsentere vores nye hjemmeside! Siden er bygget af en gruppe frivillige forældre, der ønskede at give vores klub et moderne og brugervenligt digitalt hjem.\n\n## Hvad kan du finde her?\n\n- **Nyheder** fra hele klubben\n- **Afdelingsoversigt** med information om fodbold og håndbold\n- **Tilmelding** — nu nemmere end nogensinde\n- **Om klubben** — hvem vi er og hvad vi tror på\n- **Kontaktformular** — skriv til os direkte\n\n## Feedback er velkommen!\n\nHvis du opdager fejl eller har forslag til forbedringer, er du meget velkommen til at skrive til os på [info@faelledunited.dk](mailto:info@faelledunited.dk).\n\nVi håber, du nyder den nye side!\n\n*Bestyrelsen, Fælled United*",
                'body_en'          => "# Our new website is online!\n\nDear Fælled United family,\n\nWe are incredibly proud to present our new website!",
                'is_published'     => true,
                'published_at'     => now()->subDays(2),
            ],
            [
                'news_category_id' => $fodbold->id,
                'slug'             => 'fodboldskolen-2026-tilmeld-dig-nu',
                'title_da'         => 'Fodboldskolen 2026 — Tilmeld dig nu!',
                'title_en'         => 'Football School 2026 — Sign up now!',
                'excerpt_da'       => 'Sommerens fodboldskole er snart her! I uge 28 afholder vi vores populære sommercamp for piger og drenge fra 2013-årgangen og opefter.',
                'excerpt_en'       => 'Summer football school is coming! Week 28 we run our popular summer camp.',
                'body_da'          => "# Fodboldskolen 2026\n\nSommerens mest populære begivenhed nærmer sig — **Fælled United Fodboldskolen 2026**!\n\n## Hvornår?\n\n**Uge 28:** Mandag 6. juli til fredag 10. juli 2026  \nKl. 9.00–15.00 hver dag\n\n## Hvem kan deltage?\n\nCampen er åben for alle børn i alderen **6–14 år**. Du behøver ikke at være medlem af Fælled United for at deltage — alle er velkomne!\n\n## Hvad sker der?\n\n- Teknisk træning med vores erfarne trænere\n- Kampe og turneringer\n- Fællesskab og nye venskaber\n- Afslutningsfest med præmier fredag eftermiddag\n\n## Pris\n\nDeltagergebyr: **500 kr.** per barn (inkluderer frokost og Fælled United-trøje)\n\n## Tilmelding\n\nTilmeld dig via formularen på vores hjemmeside. Pladser er begrænsede — tilmeld dig hurtigst muligt!\n\nSpørgsmål? Skriv til [info@faelledunited.dk](mailto:info@faelledunited.dk)",
                'body_en'          => "# Football School 2026\n\nSignup for our summer football camp now!",
                'is_published'     => true,
                'published_at'     => now()->subDays(7),
            ],
            [
                'news_category_id' => $arrangementer->id,
                'slug'             => 'foraarsfest-2026-alle-er-velkomne',
                'title_da'         => 'Forårsfest 2026 — Alle er velkomne!',
                'title_en'         => 'Spring Party 2026 — Everyone is welcome!',
                'excerpt_da'       => 'Lørdag d. 28. marts afholder vi vores traditionsrige forårsfest på Fælledparken. Kom og mød resten af klubben, spis god mad og fejr den nye sæson.',
                'excerpt_en'       => 'Join us for our Spring Party on March 28th at Fælledparken.',
                'body_da'          => "# Forårsfest 2026 🌱\n\nKære Fælled United-familie,\n\nVi glæder os til at samle hele klubben til **Forårsfest 2026**!\n\n## Praktiske oplysninger\n\n**Hvornår:** Lørdag d. 28. marts 2026, kl. 13.00–18.00  \n**Hvor:** Fælledparken — ved de store fodboldbaner  \n**Pris:** Gratis for alle\n\n## Program\n\n| Tidspunkt | Program |\n|-----------|----------|\n| 13:00     | Velkomst og åbning |\n| 13:30     | Opvarmningskamp: Forældre vs. trænere |\n| 14:30     | Fællesspisning — grill og hygge |\n| 16:00     | Præmieoverrækkelse og sæsonstart |\n| 18:00     | Tak for i dag! |\n\n## Tilmelding\n\nDer er ikke nødvendig tilmelding — kom bare! Dog vil vi meget gerne have en idé om deltagerantallet, så du meget gerne må skrive til os, hvis du regner med at komme.\n\nVi glæder os til at se alle!\n\n*Bestyrelsen, Fælled United*",
                'body_en'          => "# Spring Party 2026\n\nJoin us for our annual spring party!",
                'is_published'     => true,
                'published_at'     => now()->subDays(14),
            ],
            [
                'news_category_id' => $klubnyt->id,
                'slug'             => 'soeg-frivillige-traenere-til-2025-saesonnen',
                'title_da'         => 'Søger frivillige trænere til næste sæson',
                'title_en'         => 'Looking for volunteer coaches for next season',
                'excerpt_da'       => 'Vi søger engagerede voksne, der har lyst til at træne vores yngste spillere. Ingen formel træneruddannelse er nødvendig — vi sørger for kursus.',
                'excerpt_en'       => 'We are looking for volunteer coaches for our youngest players.',
                'body_da'          => "# Bliv frivillig træner hos Fælled United\n\nDrømmer du om at give noget tilbage til fællesskabet og elske du at arbejde med børn? Så er dette din chance!\n\n## Vi søger trænere til:\n\n- 2017 og 2018/2019 Piger (fodbold)\n- Håndbold — alle årgange (ny afdeling, vi bygger op fra bunden)\n\n## Hvad kræves der?\n\n- Lyst til at arbejde med børn i alderen 5–10 år\n- Evne til at møde op til træning 1–2 gange om ugen\n- Smil og positivt humør\n\nIngen formel uddannelse kræves — vi sørger for **gratis DBU-træneruddannelse** til alle nye frivillige.\n\n## Interesseret?\n\nSkriv til os på [info@faelledunited.dk](mailto:info@faelledunited.dk) med emnet \"Frivillig træner\", og fortæl lidt om dig selv.\n\nVi svarer alle henvendelser inden for en uge.",
                'body_en'          => "# Become a Volunteer Coach at Fælled United\n\nWe are looking for volunteer coaches for the upcoming season.",
                'is_published'     => true,
                'published_at'     => now()->subDays(21),
            ],
        ];

        foreach ($posts as $post) {
            NewsPost::create($post);
        }
    }
}
