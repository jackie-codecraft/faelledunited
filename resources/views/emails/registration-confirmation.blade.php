@extends('emails.layout')

@section('title', trans('email.registration.heading', [], $locale))

@section('content')

<h2 style="margin:0 0 8px;font-size:22px;color:#0f2718;font-weight:bold">{{ trans('email.registration.heading', [], $locale) }}</h2>
<p style="margin:0 0 24px;font-size:15px;color:#555555;line-height:1.5">
    {{ trans('email.registration.intro', [
        'parent_name' => $registration->parent_name,
        'player_name' => $registration->player_name,
    ], $locale) }}
</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0 0 10px;font-size:12px;font-weight:bold;text-transform:uppercase;letter-spacing:1px;color:#888888">{{ trans('email.registration.child_details', [], $locale) }}</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px;font-size:14px">
    <tr>
        <td width="140" style="padding:7px 0;color:#888888;vertical-align:top">{{ trans('email.common.name', [], $locale) }}</td>
        <td style="padding:7px 0;color:#1a1a1a;font-weight:600">{{ $registration->player_name }}</td>
    </tr>
    <tr style="background:#fafafa">
        <td style="padding:7px 8px;color:#888888;vertical-align:top">{{ trans('email.registration.date_of_birth', [], $locale) }}</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ \Carbon\Carbon::parse($registration->date_of_birth)->format('d. M Y') }}</td>
    </tr>
    <tr>
        <td style="padding:7px 0;color:#888888;vertical-align:top">{{ trans('email.common.department', [], $locale) }}</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ $registration->department?->name ?? '—' }}</td>
    </tr>
    <tr style="background:#fafafa">
        <td style="padding:7px 8px;color:#888888;vertical-align:top">{{ trans('email.registration.age_group', [], $locale) }}</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ $registration->ageGroup?->label ?? '—' }}</td>
    </tr>
    @if($registration->current_club_experience)
    <tr>
        <td style="padding:7px 0;color:#888888;vertical-align:top">{{ trans('email.registration.previous_club', [], $locale) }}</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ $registration->current_club_experience }}</td>
    </tr>
    @endif
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0 0 10px;font-size:12px;font-weight:bold;text-transform:uppercase;letter-spacing:1px;color:#888888">{{ trans('email.registration.contact_details', [], $locale) }}</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px;font-size:14px">
    <tr>
        <td width="140" style="padding:7px 0;color:#888888;vertical-align:top">{{ trans('email.common.name', [], $locale) }}</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ $registration->parent_name }}</td>
    </tr>
    <tr style="background:#fafafa">
        <td style="padding:7px 8px;color:#888888;vertical-align:top">{{ trans('email.common.email', [], $locale) }}</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ $registration->parent_email }}</td>
    </tr>
    <tr>
        <td style="padding:7px 0;color:#888888;vertical-align:top">{{ trans('email.common.phone', [], $locale) }}</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ $registration->phone }}</td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0 0 16px;font-size:14px;color:#555555;line-height:1.6">
    {{ trans('email.registration.closing', ['name' => $registration->player_name], $locale) }}
</p>

<p style="margin:0;font-size:14px;color:#555555">
    {{ trans('email.common.closing', [], $locale) }}<br>
    <strong style="color:#1a1a1a">Fælled United</strong>
</p>

@endsection
