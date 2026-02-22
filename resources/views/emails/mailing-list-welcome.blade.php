@extends('emails.layout')

@section('title', __('email.mailing.subject'))

@section('content')

<h2 style="margin:0 0 8px;font-size:22px;color:#0f2718;font-weight:bold">{{ __('email.mailing.heading') }}</h2>
<p style="margin:0 0 24px;font-size:15px;color:#555555;line-height:1.5">
    {{ __('email.mailing.intro', ['email' => $subscriber->email]) }}
</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0 0 12px;font-size:12px;font-weight:bold;text-transform:uppercase;letter-spacing:1px;color:#888888">{{ __('email.mailing.expect_heading') }}</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr>
        <td width="28" style="vertical-align:top;padding:4px 0;font-size:16px">⚽</td>
        <td style="padding:4px 0 4px 8px;font-size:14px;color:#333333;line-height:1.5">{{ __('email.mailing.expect_1') }}</td>
    </tr>
    <tr>
        <td style="vertical-align:top;padding:4px 0;font-size:16px">📅</td>
        <td style="padding:4px 0 4px 8px;font-size:14px;color:#333333;line-height:1.5">{{ __('email.mailing.expect_2') }}</td>
    </tr>
    <tr>
        <td style="vertical-align:top;padding:4px 0;font-size:16px">🏆</td>
        <td style="padding:4px 0 4px 8px;font-size:14px;color:#333333;line-height:1.5">{{ __('email.mailing.expect_3') }}</td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0 0 16px;font-size:14px;color:#555555;line-height:1.6">{{ __('email.mailing.no_spam') }}</p>

<p style="margin:0;font-size:13px;color:#aaaaaa;line-height:1.5">
    {!! __('email.mailing.unsubscribe', ['email' => '<a href="mailto:info@faelledunited.dk" style="color:#1a472a;text-decoration:none">info@faelledunited.dk</a>']) !!}
</p>

@endsection
