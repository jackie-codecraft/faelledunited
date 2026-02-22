<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model
{
    protected $fillable = [
        'content_da',
        'content_en',
    ];

    /**
     * Return the single privacy policy record, creating it with placeholder content if it doesn't exist.
     */
    public static function current(): static
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'content_da' => static::placeholderDa(),
                'content_en' => static::placeholderEn(),
            ]
        );
    }

    public static function placeholderDa(): string
    {
        return <<<'MD'
# Privatlivspolitik

*Senest opdateret: [indsæt dato]*

---

## 1. Dataansvarlig

**Fælled United**
Ørestad, København S
E-mail: info@faelledunited.dk

Fælled United er dataansvarlig for behandlingen af de personoplysninger, som vi modtager om dig og dit barn i forbindelse med brug af vores hjemmeside og tilmelding til klubben.

---

## 2. Hvilke oplysninger indsamler vi?

### Tilmelding til klubben

Når du tilmelder dit barn til Fælled United, indsamler vi:

**Om barnet:**
- Navn
- Fødselsdato
- Afdeling og aldersgruppe
- Eventuel tidligere klub

**Om forælder/værge:**
- Navn
- E-mailadresse
- Telefonnummer

### Kontaktformular

Når du sender os en besked via vores kontaktformular, indsamler vi:
- Navn
- E-mailadresse
- Beskedindhold

### Mailingliste

Når du tilmelder dig vores mailingliste, indsamler vi:
- E-mailadresse

---

## 3. Formål og retsgrundlag

| Behandling | Formål | Retsgrundlag |
|---|---|---|
| Tilmelding | Administrere medlemskab og hold | Opfyldelse af aftale (GDPR art. 6, stk. 1, litra b) + samtykke fra forælder/værge |
| Kontaktformular | Besvare din henvendelse | Legitim interesse (GDPR art. 6, stk. 1, litra f) |
| Mailingliste | Udsende nyheder og opdateringer | Samtykke (GDPR art. 6, stk. 1, litra a) |

Da vi behandler oplysninger om mindreårige, indhentes samtykke altid fra forælder eller værge.

---

## 4. Opbevaring og sletning

Vi opbevarer dine oplysninger så længe det er nødvendigt:

- **Tilmeldingsoplysninger:** Så længe barnet er aktivt medlem, og op til 2 år efter udmeldelse.
- **Kontakthenvendelser:** Op til 12 måneder efter modtagelsen.
- **Mailingliste:** Indtil du framelder dig.

---

## 5. Deling af oplysninger

Vi deler ikke dine personoplysninger med tredjeparter til markedsføring.

Vi anvender følgende databehandlere til drift af hjemmesiden:
- **Hosting og infrastruktur:** DigitalOcean (servere inden for EU)
- **E-mail:** [Indsæt e-mailudbyder, fx Mailgun eller Postmark]

Alle databehandlere er forpligtet via databehandleraftaler og må alene behandle data efter vores instruks.

---

## 6. Dine rettigheder

Du har følgende rettigheder i henhold til GDPR:

- **Indsigt:** Du kan anmode om indsigt i de oplysninger, vi har registreret om dig.
- **Berigtigelse:** Du kan anmode om, at forkerte oplysninger rettes.
- **Sletning:** Du kan anmode om at få dine oplysninger slettet ("retten til at blive glemt").
- **Begrænsning:** Du kan anmode om begrænsning af vores behandling af dine oplysninger.
- **Indsigelse:** Du kan gøre indsigelse mod behandlingen.
- **Dataportabilitet:** Du kan anmode om at modtage dine oplysninger i et struktureret, maskinlæsbart format.

For at udøve dine rettigheder, kontakt os på: **info@faelledunited.dk**

Vi vil besvare din henvendelse inden for 30 dage.

---

## 7. Klage til Datatilsynet

Hvis du mener, at vi behandler dine oplysninger i strid med gældende regler, har du ret til at indgive en klage til:

**Datatilsynet**
Carl Jacobsens Vej 35
2500 Valby
E-mail: dt@datatilsynet.dk
Web: [www.datatilsynet.dk](https://www.datatilsynet.dk)

---

## 8. Cookies

Vores hjemmeside bruger udelukkende teknisk nødvendige cookies, som ikke kræver samtykke:

- **`laravel_session`** — sessionscookie, der husker din login-status og sprogvalg
- **`XSRF-TOKEN`** — sikkerhedscookie, der beskytter mod CSRF-angreb

Vi anvender ingen sporings-, analyse- eller marketingcookies.
MD;
    }

    public static function placeholderEn(): string
    {
        return <<<'MD'
# Privacy Policy

*Last updated: [insert date]*

---

## 1. Data Controller

**Fælled United**
Ørestad, Copenhagen S
Email: info@faelledunited.dk

Fælled United is the data controller for the personal data we receive about you and your child in connection with your use of our website and registration with the club.

---

## 2. What data do we collect?

### Club registration

When you register your child with Fælled United, we collect:

**About the child:**
- Name
- Date of birth
- Department and age group
- Previous club (if any)

**About the parent/guardian:**
- Name
- Email address
- Phone number

### Contact form

When you send us a message via our contact form, we collect:
- Name
- Email address
- Message content

### Mailing list

When you sign up for our mailing list, we collect:
- Email address

---

## 3. Purposes and legal basis

| Processing | Purpose | Legal basis |
|---|---|---|
| Registration | Manage membership and teams | Performance of a contract (GDPR Art. 6(1)(b)) + parental consent |
| Contact form | Respond to your enquiry | Legitimate interest (GDPR Art. 6(1)(f)) |
| Mailing list | Send news and updates | Consent (GDPR Art. 6(1)(a)) |

As we process data about minors, consent is always obtained from a parent or guardian.

---

## 4. Retention and deletion

We retain your data only as long as necessary:

- **Registration data:** For as long as the child is an active member, and up to 2 years after they leave the club.
- **Contact enquiries:** Up to 12 months after receipt.
- **Mailing list:** Until you unsubscribe.

---

## 5. Sharing of data

We do not share your personal data with third parties for marketing purposes.

We use the following data processors to operate our website:
- **Hosting and infrastructure:** DigitalOcean (EU region servers)
- **Email:** [Insert email provider, e.g. Mailgun or Postmark]

All data processors are bound by data processing agreements and may only process data according to our instructions.

---

## 6. Your rights

Under GDPR, you have the following rights:

- **Access:** You may request access to the personal data we hold about you.
- **Rectification:** You may request correction of inaccurate data.
- **Erasure:** You may request deletion of your data (the "right to be forgotten").
- **Restriction:** You may request that we restrict our processing of your data.
- **Objection:** You may object to the processing of your data.
- **Portability:** You may request your data in a structured, machine-readable format.

To exercise any of these rights, contact us at: **info@faelledunited.dk**

We will respond to your request within 30 days.

---

## 7. Complaint to the Danish Data Protection Agency

If you believe we are processing your data in violation of applicable rules, you have the right to lodge a complaint with:

**Datatilsynet** (Danish Data Protection Agency)
Carl Jacobsens Vej 35
2500 Valby
Email: dt@datatilsynet.dk
Web: [www.datatilsynet.dk](https://www.datatilsynet.dk)

---

## 8. Cookies

Our website uses only technically necessary cookies, which do not require consent:

- **`laravel_session`** — session cookie that maintains your login status and language preference
- **`XSRF-TOKEN`** — security cookie that protects against CSRF attacks

We do not use any tracking, analytics, or marketing cookies.
MD;
    }
}
