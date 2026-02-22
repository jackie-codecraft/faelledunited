@extends('emails.layout')

@section('title', 'Tilmelding modtaget')

@section('content')

<h2 style="margin:0 0 8px;font-size:22px;color:#0f2718;font-weight:bold">Tilmelding modtaget!</h2>
<p style="margin:0 0 24px;font-size:15px;color:#555555;line-height:1.5">
    Tak, {{ $registration->parent_name }}! Vi har modtaget tilmeldingen for
    <strong style="color:#1a1a1a">{{ $registration->player_name }}</strong>.
    Vi kontakter dig hurtigst muligt for at bekræfte pladsen.
</p>

{{-- Divider --}}
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

{{-- Child details --}}
<p style="margin:0 0 10px;font-size:12px;font-weight:bold;text-transform:uppercase;letter-spacing:1px;color:#888888">Barnets oplysninger</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px;font-size:14px">
    <tr>
        <td width="140" style="padding:7px 0;color:#888888;vertical-align:top">Navn</td>
        <td style="padding:7px 0;color:#1a1a1a;font-weight:600">{{ $registration->player_name }}</td>
    </tr>
    <tr style="background:#fafafa">
        <td style="padding:7px 8px;color:#888888;vertical-align:top">Fødselsdato</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ \Carbon\Carbon::parse($registration->date_of_birth)->format('d. M Y') }}</td>
    </tr>
    <tr>
        <td style="padding:7px 0;color:#888888;vertical-align:top">Afdeling</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ $registration->department?->name_da ?? '—' }}</td>
    </tr>
    <tr style="background:#fafafa">
        <td style="padding:7px 8px;color:#888888;vertical-align:top">Årgang / Hold</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ $registration->ageGroup?->label_da ?? '—' }}</td>
    </tr>
    @if($registration->current_club_experience)
    <tr>
        <td style="padding:7px 0;color:#888888;vertical-align:top">Tidligere klub</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ $registration->current_club_experience }}</td>
    </tr>
    @endif
</table>

{{-- Divider --}}
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

{{-- Parent details --}}
<p style="margin:0 0 10px;font-size:12px;font-weight:bold;text-transform:uppercase;letter-spacing:1px;color:#888888">Kontaktoplysninger</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px;font-size:14px">
    <tr>
        <td width="140" style="padding:7px 0;color:#888888;vertical-align:top">Navn</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ $registration->parent_name }}</td>
    </tr>
    <tr style="background:#fafafa">
        <td style="padding:7px 8px;color:#888888;vertical-align:top">E-mail</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ $registration->parent_email }}</td>
    </tr>
    <tr>
        <td style="padding:7px 0;color:#888888;vertical-align:top">Telefon</td>
        <td style="padding:7px 0;color:#1a1a1a">{{ $registration->phone }}</td>
    </tr>
</table>

{{-- Divider --}}
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0 0 16px;font-size:14px;color:#555555;line-height:1.6">
    Vi glæder os til at byde <strong>{{ $registration->player_name }}</strong> velkommen i Fælled United!
    Har du spørgsmål, er du velkommen til at skrive til os.
</p>

<p style="margin:0;font-size:14px;color:#555555">
    Med venlig hilsen,<br>
    <strong style="color:#1a1a1a">Fælled United</strong>
</p>

@endsection
