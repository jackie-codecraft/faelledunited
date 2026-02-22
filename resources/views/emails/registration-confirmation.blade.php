@extends('emails.layout')

@section('title', __('email.registration.heading'))

@section('content')

<h2 style="margin:0 0 8px;font-size:22px;color:#0f2718;font-weight:bold">{{ __('email.registration.heading') }}</h2>
<p style="margin:0 0 24px;font-size:15px;color:#555555;line-height:1.5">
    {{ __('email.registration.intro', [
        'parent_name' => $registration->parent_name,
        'player_name' => $registration->player_name,
    ]) }}
</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0 0 10px;font-size:12px;font-weight:bold;text-transform:uppercase;letter-spacing:1px;color:#888888">{{ __('email.registration.child_details') }}</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px;font-size:14px">
    <tr>
        <td width="140" style="padding:7px 0;color:#888888;vertical-align:top">{{ __('email.common.name') }}</td>
        <td style="padding:7px 0;color:#1a1a1a;font-weight:600">{{ $registration->player_name }}</td>
    </tr>
    <tr style="background:#fafafa">
        <td style="padding:7px 8px;color:#888888;vertical-align:top">{{ __('email.registration.date_of_birth') }}</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ \Carbon\Carbon::parse($registration->date_of_birth)->format('d. M Y') }}</td>
    </tr>
    <tr>
        <td style="padding:7px 0;color:#888888;vertical-align:top">{{ __('email.common.department') }}</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ $registration->department?->name_da ?? '—' }}</td>
    </tr>
    <tr style="background:#fafafa">
        <td style="padding:7px 8px;color:#888888;vertical-align:top">{{ __('email.registration.age_group') }}</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ $registration->ageGroup?->label_da ?? '—' }}</td>
    </tr>
    @if($registration->current_club_experience)
    <tr>
        <td style="padding:7px 0;color:#888888;vertical-align:top">{{ __('email.registration.previous_club') }}</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ $registration->current_club_experience }}</td>
    </tr>
    @endif
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0 0 10px;font-size:12px;font-weight:bold;text-transform:uppercase;letter-spacing:1px;color:#888888">{{ __('email.registration.contact_details') }}</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px;font-size:14px">
    <tr>
        <td width="140" style="padding:7px 0;color:#888888;vertical-align:top">{{ __('email.common.name') }}</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ $registration->parent_name }}</td>
    </tr>
    <tr style="background:#fafafa">
        <td style="padding:7px 8px;color:#888888;vertical-align:top">{{ __('email.common.email') }}</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ $registration->parent_email }}</td>
    </tr>
    <tr>
        <td style="padding:7px 0;color:#888888;vertical-align:top">{{ __('email.common.phone') }}</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ $registration->phone }}</td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0 0 16px;font-size:14px;color:#555555;line-height:1.6">
    {{ __('email.registration.closing', ['name' => $registration->player_name]) }}
</p>

<p style="margin:0;font-size:14px;color:#555555">
    {{ __('email.common.closing') }}<br>
    <strong style="color:#1a1a1a">Fælled United</strong>
</p>

@endsection
