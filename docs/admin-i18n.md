# Admin Panel — Multilingual Pattern

All Filament admin resources must be fully multilingual. The admin panel supports per-user language preference (currently DA and EN). **Never hardcode display strings** — everything visible to the user must go through `__()`.

---

## How the locale works

The `SetAdminLocale` middleware (runs last in the panel middleware stack) reads `$request->user()->locale` and calls `app()->setLocale()`. This means `__()` calls inside resource methods and closures correctly resolve to the user's language at request time.

The two translation files are:
- `lang/da.json` — Danish (keys are also in Danish for the public site, but admin keys use dot-notation like `admin.nav_group.club`)
- `lang/en.json` — same keys, English values

---

## Checklist for every new Resource

### 1. Navigation & model labels — use method overrides, not static properties

Static properties (`protected static ?string $navigationLabel = 'Foo'`) are set at class-load time. `__()` doesn't work in them. **Always override the methods instead:**

```php
// ✅ Correct
public static function getNavigationGroup(): ?string  { return __('admin.nav_group.club'); }
public static function getNavigationLabel(): string   { return __('admin.nav.my_resource'); }
public static function getModelLabel(): string        { return __('admin.model.my_model'); }
public static function getPluralModelLabel(): string  { return __('admin.model.my_models'); }

// ❌ Wrong — __() never runs here
protected static ?string $navigationLabel = 'My Resource';
```

These are safe to use as static properties (they don't need translation):
```php
protected static ?string $navigationIcon = 'heroicon-o-something';
protected static ?int    $navigationSort = 1;
```

### 2. Table column labels — always use `__()`

```php
// ✅ Correct
Tables\Columns\TextColumn::make('name_da')
    ->label(__('admin.col.name')),

// ❌ Wrong
Tables\Columns\TextColumn::make('name_da')
    ->label('Name'),
```

### 3. Form section headings — always use `__()`

```php
// ✅ Correct
Forms\Components\Section::make(__('admin.section.basic_info'))
    ->schema([...]),

// ❌ Wrong
Forms\Components\Section::make('Basic Info')
    ->schema([...]),
```

### 4. Form field labels — always use `__()`

```php
// ✅ Correct
Forms\Components\TextInput::make('name_da')
    ->label(__('admin.field.name_da')),

// ❌ Wrong
Forms\Components\TextInput::make('name_da')
    ->label('Name (Danish)'),
```

### 5. Navigation groups in AdminPanelProvider — must use closures

Labels on `NavigationGroup` are evaluated during panel setup (before middleware). Use a closure so the label is resolved lazily at request time:

```php
// ✅ Correct
NavigationGroup::make()
    ->label(fn () => __('admin.nav_group.club'))
    ->icon('heroicon-o-building-office-2'),

// ❌ Wrong — evaluated too early, always uses the default locale
NavigationGroup::make()
    ->label('Club')
    ->icon('heroicon-o-building-office-2'),
```

---

## Translation key namespaces

| Namespace | Used for | Example |
|---|---|---|
| `admin.nav_group.*` | NavigationGroup labels | `admin.nav_group.club` |
| `admin.nav.*` | Resource navigation labels | `admin.nav.departments` |
| `admin.model.*` | Singular + plural model labels | `admin.model.department`, `admin.model.departments` |
| `admin.col.*` | Table column headers | `admin.col.name`, `admin.col.sort_order` |
| `admin.field.*` | Form field labels | `admin.field.name_da`, `admin.field.hero_image` |
| `admin.section.*` | Form section headings | `admin.section.basic_info`, `admin.section.publishing` |

---

## Adding a new resource — step by step

1. Create the resource with `php artisan make:filament-resource`
2. Add translation keys to **both** `lang/da.json` and `lang/en.json`
3. Replace all static property labels with method overrides
4. Replace all `->label('...')` calls in `table()` and `form()` with `__('admin.xxx')`
5. Check: no hardcoded English strings anywhere in the resource

---

## Already-defined reusable keys

Many common column/field labels already exist. Check before adding duplicates:

```
admin.col.name, admin.col.slug, admin.col.sort_order, admin.col.active,
admin.col.department, admin.col.name_da, admin.col.birth_year, admin.col.role_da,
admin.col.email, admin.col.order, admin.col.title, admin.col.category,
admin.col.published, admin.col.date, admin.col.created, admin.col.team,
admin.col.child, admin.col.born, admin.col.parent, admin.col.gdpr,
admin.col.status, admin.col.submitted

admin.nav_group.club, admin.nav_group.news, admin.nav_group.members,
admin.nav_group.communications

admin.nav.departments, admin.nav.age_groups, admin.nav.board_members,
admin.nav.posts, admin.nav.categories, admin.nav.registrations,
admin.nav.contact_inquiries, admin.nav.mailing_list
```
