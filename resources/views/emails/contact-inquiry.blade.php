@extends('emails.layout')

@section('title', 'Vi har modtaget din besked')

@section('content')

<h2 style="margin:0 0 8px;font-size:22px;color:#0f2718;font-weight:bold">Tak for din besked, {{ $inquiry->name }}!</h2>
<p style="margin:0 0 24px;font-size:15px;color:#555555;line-height:1.5">Vi har modtaget din henvendelse og vender tilbage til dig hurtigst muligt — typisk inden for 2 hverdage.</p>

{{-- Divider --}}
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

{{-- Message summary --}}
<p style="margin:0 0 6px;font-size:12px;font-weight:bold;text-transform:uppercase;letter-spacing:1px;color:#888888">Din besked</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:20px">
    <tr>
        <td width="90" style="padding:8px 0;font-size:13px;color:#888888;vertical-align:top">Emne</td>
        <td style="padding:8px 0;font-size:14px;color:#1a1a1a;font-weight:600">{{ $inquiry->subject }}</td>
    </tr>
    <tr>
        <td style="border-top:1px solid #f0f0f0"></td>
        <td style="border-top:1px solid #f0f0f0"></td>
    </tr>
    <tr>
        <td style="padding:12px 0 4px;font-size:13px;color:#888888;vertical-align:top">Besked</td>
        <td style="padding:12px 0 4px;font-size:14px;color:#1a1a1a;line-height:1.6">{{ $inquiry->message }}</td>
    </tr>
</table>

{{-- Divider --}}
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0;font-size:14px;color:#555555;line-height:1.6">
    Har du spørgsmål, er du velkommen til at skrive til os på
    <a href="mailto:info@faelledunited.dk" style="color:#1a472a;text-decoration:none;font-weight:600">info@faelledunited.dk</a>.
</p>

<p style="margin:24px 0 0;font-size:14px;color:#555555">
    Med venlig hilsen,<br>
    <strong style="color:#1a1a1a">Fælled United</strong>
</p>

@endsection
