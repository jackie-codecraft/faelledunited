# Fælled United — Club Website

Official website for **Fælled United**, a youth football and handball club in Copenhagen.
Built by parent volunteers with ❤️.

---

## Tech Stack

| Layer          | Technology                     |
|----------------|--------------------------------|
| Framework      | Laravel 12 (PHP 8.3+)          |
| Admin panel    | Filament 3.x                   |
| CSS            | Tailwind CSS 4.x (via Vite)    |
| JS             | Alpine.js                      |
| Database       | SQLite (dev) → MySQL (prod)    |
| Markdown       | league/commonmark              |
| Spam filter    | Friendly Captcha *(pending)*   |

---

## Local Setup

```bash
# 1. Clone the repository
git clone https://github.com/jackie-codecraft/faelledunited.git
cd faelledunited/app

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
npm install

# 4. Environment setup
cp .env.example .env
php artisan key:generate

# 5. Database (SQLite)
touch database/database.sqlite
php artisan migrate --seed

# 6. Start dev server
npm run dev           # Vite (in one terminal)
php artisan serve     # Laravel (in another terminal)
```

Visit: **http://localhost:8000**  
Admin panel: **http://localhost:8000/admin**

Admin login (dev):
- Email: `sam@sc-codecraft.com`
- Password: `changeme`

---

## Public Pages

| URL                        | Description                              |
|----------------------------|------------------------------------------|
| `/`                        | Homepage with hero, departments, news    |
| `/nyheder`                 | News listing with pagination             |
| `/nyheder/{slug}`          | News article (Markdown rendered)         |
| `/afdelinger`              | Department overview                      |
| `/afdelinger/{slug}`       | Department detail with age groups        |
| `/tilmeld`                 | Registration form                        |
| `/kontakt`                 | Contact form                             |
| `/om-klubben`              | About page + board members               |
| `/vedtaegter`              | Club bylaws (rendered from Markdown)     |
| `/admin`                   | Filament admin panel                     |

---

## Admin Panel

All content is manageable via the Filament admin panel at `/admin`:

- **Nyheder** — Create, edit, publish news posts. Slug auto-generates from title.
- **Afdelinger** — Manage departments and their descriptions.
- **Årgange** — Age groups per department.
- **Tilmeldinger** — View and process registrations.
- **Kontakthenvendelser** — Inbox for contact form submissions.
- **Bestyrelsesmedlemmer** — Manage board member profiles.
- **Nyhedskategorier** — News categories.
- **Nyhedsbrevabonnenter** — Newsletter subscriber list.

---

## Seeded Data

Running `php artisan migrate:fresh --seed` populates:

- **2 departments:** Fodbold, Håndbold
- **11 Fodbold age groups** (2010 Drenge → 2018/2019 Piger)
- **1 Håndbold placeholder** age group
- **4 news categories:** Klubnyt, Fodbold, Håndbold, Arrangementer
- **4 sample news posts** in Danish
- **4 board member placeholders**
- **1 admin user** (`sam@sc-codecraft.com` / `changeme`)

---

## Vedtægter

The bylaws page at `/vedtaegter` renders from:
1. `storage/app/vedtaegter.md` — if this file exists
2. Built-in placeholder Markdown — if the file does not exist

To update the real bylaws, create `storage/app/vedtaegter.md` with the content.

---

## Open Questions for Sam

These need answers before launch:

| # | Question | Current State |
|---|----------|---------------|
| 1 | **Exact logo hex values** (green + gold) | Placeholders: `#1a472a` + `#c9a84c` |
| 2 | **Hero photo / club photos** | CSS gradient placeholder |
| 3 | **Friendly Captcha sitekey** | Comment left in forms (both reg + contact) |
| 4 | **SMTP provider** (for form notification emails) | `log` driver — emails go to `storage/logs/laravel.log` |
| 5 | **Social media URLs** (Facebook, Instagram) | `#` placeholder in footer |
| 6 | **Club address** | "Fælledparken, 2100 København Ø" — confirm |
| 7 | **Real vedtægter content** | Danish placeholder in-code; upload `storage/app/vedtaegter.md` |
| 8 | **Board member photos + real names/emails** | Placeholder names seeded |
| 9 | **Active age groups subset** (or all?) | All PRD age groups seeded, all active |
| 10 | **Domain / hosting** | Recommend DigitalOcean droplet + Cloudflare |

---

## Production Deployment Checklist

```bash
# .env changes for production
APP_ENV=production
APP_DEBUG=false
APP_URL=https://faelledunited.dk

DB_CONNECTION=mysql
DB_HOST=...
DB_DATABASE=faelledunited
DB_USERNAME=...
DB_PASSWORD=...

MAIL_MAILER=smtp   # or postmark / brevo
# ... SMTP credentials

# Commands
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

---

## Development Notes

- **Tailwind CSS 4.x** — uses `@theme` CSS variables (no `tailwind.config.js` needed)
- **Alpine.js** — handles mobile navbar toggle + registration form department filtering
- **Filament** — auto-discovers resources from `app/Filament/Resources/`
- **Markdown** — `league/commonmark` in `NewsController` and `PageController`
- **SQLite** — dev default; switch to MySQL for production via `.env`

---

*Maintained by Sam Ciaramilaro and the Fælled United parent volunteer team.*
