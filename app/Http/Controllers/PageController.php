<?php

namespace App\Http\Controllers;

use App\Models\BoardMember;
use App\Models\PrivacyPolicy;
use App\Models\Statute;
use League\CommonMark\CommonMarkConverter;

class PageController extends Controller
{
    public function shop()
    {
        return view('pages.shop');
    }

    public function about()
    {
        $boardMembers = BoardMember::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('pages.about', compact('boardMembers'));
    }

    public function vedtaegter()
    {
        $statute = Statute::current();
        $locale = app()->getLocale();

        $field = $locale === 'en' ? 'content_en' : 'content_da';
        $markdown = $statute->{$field} ?: $this->vedtaegterPlaceholder($locale);

        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $contentHtml = $converter->convert($markdown)->getContent();
        $updatedAt = $statute->updated_at;

        return view('pages.vedtaegter', compact('contentHtml', 'updatedAt'));
    }

    public function privacyPolicy()
    {
        $policy = PrivacyPolicy::current();
        $locale = app()->getLocale();

        $field = $locale === 'en' ? 'content_en' : 'content_da';
        $markdown = $policy->{$field};

        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $contentHtml = $converter->convert($markdown)->getContent();
        $updatedAt = $policy->updated_at;

        return view('pages.privacy', compact('contentHtml', 'updatedAt'));
    }

    private function vedtaegterPlaceholder(string $locale = 'da'): string
    {
        if ($locale === 'en') {
            return <<<'MD'
# Statutes of Fælled United

*Adopted at the general assembly — date to be inserted here*

---

## § 1 — Name and domicile

The name of the association is **Fælled United**. The association is domiciled in the Municipality of Copenhagen.

## § 2 — Purpose

The purpose of the association is to promote football and handball for children and young people in Copenhagen, and to create a safe and inclusive community for players, families, and volunteers.

## § 3 — Membership

Any person wishing to support the association's purpose may be admitted as a member. The board may refuse admission if special reasons so dictate.

## § 4 — Membership fees

Membership fees are set by the board for each season and communicated to all members in good time.

## § 5 — General assembly

The general assembly is the supreme authority of the association. The ordinary general assembly is held each year in the first quarter. Notice is given with at least 14 days' notice.

### Agenda

The ordinary general assembly addresses:

1. Election of a chairperson
2. Report from the board
3. Presentation of accounts
4. Setting of membership fees
5. Election of board members
6. Election of auditor
7. Any other business

## § 6 — Board

The board consists of at least 3 and at most 7 members, elected for 2-year terms at the general assembly.

## § 7 — Accounts and audit

The association's financial year runs from 1 January to 31 December. The accounts are audited by an auditor elected at the general assembly.

## § 8 — Amendments to the statutes

Amendments to the statutes require a 2/3 majority at an ordinary or extraordinary general assembly.

## § 9 — Dissolution

Dissolution of the association requires a 2/3 majority at two consecutive general assemblies with at least 4 weeks between them. Upon dissolution, the association's assets are transferred to a charitable cause within children's sport in Copenhagen.

---

*These statutes are placeholders — Sam will update them with the final statutes.*
MD;
        }

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
