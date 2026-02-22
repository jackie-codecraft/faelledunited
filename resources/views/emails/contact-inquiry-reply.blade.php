@extends('emails.layout')

@section('title', trans('email.inquiry_reply.subject', [], $locale))

@section('content')

<h2 style="margin:0 0 8px;font-size:22px;color:#0f2718;font-weight:bold">{{ trans('email.inquiry_reply.heading', ['name' => $inquiry->name], $locale) }}</h2>
<p style="margin:0 0 24px;font-size:15px;color:#555555;line-height:1.5">{{ trans('email.inquiry_reply.intro', [], $locale) }}</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0 0 12px;font-size:12px;font-weight:bold;text-transform:uppercase;letter-spacing:1px;color:#888888">{{ trans('email.inquiry_reply.reply_label', [], $locale) }}</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr>
        <td style="padding:16px;background-color:#f8f8f8;border-left:4px solid #1a472a;border-radius:0 4px 4px 0;font-size:14px;color:#1a1a1a;line-height:1.7">
            {{ $replyMessage }}
        </td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0 0 12px;font-size:12px;font-weight:bold;text-transform:uppercase;letter-spacing:1px;color:#888888">{{ trans('email.inquiry_reply.your_original', [], $locale) }}</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr>
        <td width="120" style="padding:8px 0;font-size:13px;color:#888888;vertical-align:top">{{ trans('email.common.subject', [], $locale) }}</td>
        <td style="padding:8px 0;font-size:14px;color:#1a1a1a;font-weight:600">{{ $inquiry->subject }}</td>
    </tr>
    <tr>
        <td style="border-top:1px solid #f0f0f0" colspan="2"></td>
    </tr>
    <tr>
        <td style="padding:12px 0 4px;font-size:13px;color:#888888;vertical-align:top">{{ trans('email.common.message', [], $locale) }}</td>
        <td style="padding:12px 0 4px;font-size:14px;color:#1a1a1a;line-height:1.6">{{ $inquiry->message }}</td>
    </tr>
</table>

<p style="margin:24px 0 0;font-size:14px;color:#555555">
    {{ trans('email.common.closing', [], $locale) }}<br>
    <strong style="color:#1a1a1a">Fælled United</strong>
</p>

@endsection
