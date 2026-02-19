<?php

namespace App\Http\Controllers;

use App\Models\BoardMember;
use League\CommonMark\CommonMarkConverter;

class PageController extends Controller
{
    public function about()
    {
        $boardMembers = BoardMember::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('pages.about', compact('boardMembers'));
    }

    public function vedtaegter()
    {
        // Render vedtaegter from Markdown file in storage or inline placeholder
        $markdownPath = storage_path('app/vedtaegter.md');
        $markdown = file_exists($markdownPath)
            ? file_get_contents($markdownPath)
            : $this->vedtaegterPlaceholder();

        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $contentHtml = $converter->convert($markdown)->getContent();

        return view('pages.vedtaegter', compact('contentHtml'));
    }

    private function vedtaegterPlaceholder(): string
    {
        return <<<'MD'
# Vedtægter for Fælled United

*Vedtaget på generalforsamlingen — dato indsættes her*

---

## § 1 — Navn og hjemsted

Foreningens navn er **Fælled United**. Foreningens hjemsted er Københavns Kommune.

## § 2 — Formål

Foreningens formål er at fremme fodbold og håndbold for børn og unge i København, samt at skabe et trygt og inkluderende fællesskab for spillere, familier og frivillige.

## § 3 — Medlemskab

Enhver person, der ønsker at støtte foreningens formål, kan optages som medlem. Bestyrelsen kan nægte optagelse, hvis særlige grunde taler herfor.

## § 4 — Kontingent

Kontingentet fastsættes af bestyrelsen for hvert sæson og meddeles alle medlemmer i god tid.

## § 5 — Generalforsamlingen

Generalforsamlingen er foreningens øverste myndighed. Ordinær generalforsamling afholdes hvert år i første kvartal. Indkaldelse sker med mindst 14 dages varsel.

### Dagsorden

Den ordinære generalforsamling behandler:

1. Valg af dirigent
2. Beretning fra bestyrelsen
3. Fremlæggelse af regnskab
4. Fastsættelse af kontingent
5. Valg af bestyrelse
6. Valg af revisor
7. Eventuelt

## § 6 — Bestyrelsen

Bestyrelsen består af mindst 3 og højest 7 medlemmer, der vælges for 2 år ad gangen på generalforsamlingen.

## § 7 — Regnskab og revision

Foreningens regnskabsår løber fra 1. januar til 31. december. Regnskabet revideres af en på generalforsamlingen valgt revisor.

## § 8 — Vedtægtsændringer

Vedtægtsændringer kræver 2/3 flertal på en ordinær eller ekstraordinær generalforsamling.

## § 9 — Opløsning

Opløsning af foreningen kræver 2/3 flertal på to hinanden følgende generalforsamlinger med mindst 4 ugers mellemrum. Ved opløsning tilfalder foreningens midler et almennyttigt formål inden for børnesport i København.

---

*Disse vedtægter er placeholders — Sam opdaterer dem med de endelige vedtægter.*
MD;
    }
}
