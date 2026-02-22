@extends('emails.layout')

@section('title', trans('email.mailing.subject', [], $locale))

@section('content')

<h2 style="margin:0 0 8px;font-size:22px;color:#0f2718;font-weight:bold">{{ trans('email.mailing.heading', [], $locale) }}</h2>
<p style="margin:0 0 24px;font-size:15px;color:#555555;line-height:1.5">
    {{ trans('email.mailing.intro', ['email' => $subscriber->email], $locale) }}
</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0 0 12px;font-size:12px;font-weight:bold;text-transform:uppercase;letter-spacing:1px;color:#888888">{{ trans('email.mailing.expect_heading', [], $locale) }}</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr>
        <td width="28" style="vertical-align:top;padding:4px 0;font-size:16px">⚽</td>
        <td style="padding:4px 0 4px 8px;font-size:14px;color:#333333;line-height:1.5">{{ trans('email.mailing.expect_1', [], $locale) }}</td>
    </tr>
    <tr>
        <td style="vertical-align:top;padding:4px 0;font-size:16px">📅</td>
        <td style="padding:4px 0 4px 8px;font-size:14px;color:#333333;line-height:1.5">{{ trans('email.mailing.expect_2', [], $locale) }}</td>
    </tr>
    <tr>
        <td style="vertical-align:top;padding:4px 0;font-size:16px">🏆</td>
        <td style="padding:4px 0 4px 8px;font-size:14px;color:#333333;line-height:1.5">{{ trans('email.mailing.expect_3', [], $locale) }}</td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0 0 24px;font-size:14px;color:#555555;line-height:1.6">{{ trans('email.mailing.no_spam', [], $locale) }}</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:16px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0;font-size:12px;color:#aaaaaa;line-height:1.6;text-align:center">
    {{ trans('email.mailing.unsubscribe_prompt', [], $locale) }}<br>
    <a href="{{ $unsubscribeUrl }}" style="color:#888888;text-decoration:underline;font-size:12px">
        {{ trans('email.mailing.unsubscribe_link', [], $locale) }}
    </a>
</p>

@endsection
