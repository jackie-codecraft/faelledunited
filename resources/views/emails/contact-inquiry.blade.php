@extends('emails.layout')

@section('title', __('email.contact.subject'))

@section('content')

<h2 style="margin:0 0 8px;font-size:22px;color:#0f2718;font-weight:bold">{{ __('email.contact.heading', ['name' => $inquiry->name]) }}</h2>
<p style="margin:0 0 24px;font-size:15px;color:#555555;line-height:1.5">{{ __('email.contact.intro') }}</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0 0 6px;font-size:12px;font-weight:bold;text-transform:uppercase;letter-spacing:1px;color:#888888">{{ __('email.contact.your_message') }}</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:20px">
    <tr>
        <td width="90" style="padding:8px 0;font-size:13px;color:#888888;vertical-align:top">{{ __('email.common.subject') }}</td>
        <td style="padding:8px 0;font-size:14px;color:#1a1a1a;font-weight:600">{{ $inquiry->subject }}</td>
    </tr>
    <tr>
        <td style="border-top:1px solid #f0f0f0"></td>
        <td style="border-top:1px solid #f0f0f0"></td>
    </tr>
    <tr>
        <td style="padding:12px 0 4px;font-size:13px;color:#888888;vertical-align:top">{{ __('email.common.message') }}</td>
        <td style="padding:12px 0 4px;font-size:14px;color:#1a1a1a;line-height:1.6">{{ $inquiry->message }}</td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0;font-size:14px;color:#555555;line-height:1.6">
    {!! __('email.contact.footer', ['email' => '<a href="mailto:info@faelledunited.dk" style="color:#1a472a;text-decoration:none;font-weight:600">info@faelledunited.dk</a>']) !!}
</p>

<p style="margin:24px 0 0;font-size:14px;color:#555555">
    {{ __('email.common.closing') }}<br>
    <strong style="color:#1a1a1a">Fælled United</strong>
</p>

@endsection
