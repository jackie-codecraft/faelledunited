@extends('emails.layout')

@section('title', 'Velkommen til vores mailliste')

@section('content')

<h2 style="margin:0 0 8px;font-size:22px;color:#0f2718;font-weight:bold">Du er med på holdet! 🎉</h2>
<p style="margin:0 0 24px;font-size:15px;color:#555555;line-height:1.5">
    Tak for din tilmelding til Fælled Uniteds mailliste. Du er nu tilmeldt med <strong>{{ $subscriber->email }}</strong>.
</p>

{{-- Divider --}}
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0 0 12px;font-size:12px;font-weight:bold;text-transform:uppercase;letter-spacing:1px;color:#888888">Hvad kan du forvente?</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr>
        <td width="28" style="vertical-align:top;padding:4px 0;font-size:16px">⚽</td>
        <td style="padding:4px 0 4px 8px;font-size:14px;color:#333333;line-height:1.5">Nyheder og opdateringer fra klubben</td>
    </tr>
    <tr>
        <td style="vertical-align:top;padding:4px 0;font-size:16px">📅</td>
        <td style="padding:4px 0 4px 8px;font-size:14px;color:#333333;line-height:1.5">Kommende arrangementer og kampe</td>
    </tr>
    <tr>
        <td style="vertical-align:top;padding:4px 0;font-size:16px">🏆</td>
        <td style="padding:4px 0 4px 8px;font-size:14px;color:#333333;line-height:1.5">Resultater og historier fra holdene</td>
    </tr>
</table>

{{-- Divider --}}
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0 0 16px;font-size:14px;color:#555555;line-height:1.6">
    Vi sender kun e-mails når der er noget vigtigt at dele — ingen spam.
</p>

<p style="margin:0;font-size:13px;color:#aaaaaa;line-height:1.5">
    Ønsker du at afmelde dig, kan du kontakte os på
    <a href="mailto:info@faelledunited.dk" style="color:#1a472a;text-decoration:none">info@faelledunited.dk</a>.
</p>

@endsection
