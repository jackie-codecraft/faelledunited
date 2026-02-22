@extends('emails.layout')

@section('title', trans('email.inquiry_notification.subject', ['name' => $inquiry->name], $locale))

@section('content')

<h2 style="margin:0 0 8px;font-size:22px;color:#0f2718;font-weight:bold">{{ trans('email.inquiry_notification.heading', [], $locale) }}</h2>
<p style="margin:0 0 24px;font-size:15px;color:#555555;line-height:1.5">{{ trans('email.inquiry_notification.intro', [], $locale) }}</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0 0 12px;font-size:12px;font-weight:bold;text-transform:uppercase;letter-spacing:1px;color:#888888">{{ trans('email.inquiry_notification.details', [], $locale) }}</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr>
        <td width="120" style="padding:8px 0;font-size:13px;color:#888888;vertical-align:top">{{ trans('email.common.name', [], $locale) }}</td>
        <td style="padding:8px 0;font-size:14px;color:#1a1a1a;font-weight:600">{{ $inquiry->name }}</td>
    </tr>
    <tr>
        <td style="border-top:1px solid #f0f0f0" colspan="2"></td>
    </tr>
    <tr>
        <td style="padding:8px 0;font-size:13px;color:#888888;vertical-align:top">{{ trans('email.common.email', [], $locale) }}</td>
        <td style="padding:8px 0;font-size:14px;color:#1a1a1a">{{ $inquiry->email }}</td>
    </tr>
    <tr>
        <td style="border-top:1px solid #f0f0f0" colspan="2"></td>
    </tr>
    <tr>
        <td style="padding:8px 0;font-size:13px;color:#888888;vertical-align:top">{{ trans('email.common.subject', [], $locale) }}</td>
        <td style="padding:8px 0;font-size:14px;color:#1a1a1a;font-weight:600">{{ $inquiry->subject }}</td>
    </tr>
    <tr>
        <td style="border-top:1px solid #f0f0f0" colspan="2"></td>
    </tr>
    <tr>
        <td style="padding:12px 0 4px;font-size:13px;color:#888888;vertical-align:top">{{ trans('email.common.message', [], $locale) }}</td>
        <td style="padding:12px 0 4px;font-size:14px;color:#1a1a1a;line-height:1.6">{{ $inquiry->message }}</td>
    </tr>
    <tr>
        <td style="border-top:1px solid #f0f0f0" colspan="2"></td>
    </tr>
    <tr>
        <td style="padding:8px 0;font-size:13px;color:#888888;vertical-align:top">{{ trans('email.inquiry_notification.submitted_at', [], $locale) }}</td>
        <td style="padding:8px 0;font-size:14px;color:#1a1a1a">{{ $inquiry->created_at->format('d. M Y H:i') }}</td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:32px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

{{-- Reply button --}}
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:32px">
    <tr>
        <td align="center">
            <a href="{{ $replyUrl }}"
               style="display:inline-block;background-color:#1a472a;color:#ffffff;font-size:16px;font-weight:bold;text-decoration:none;padding:14px 32px;border-radius:6px;letter-spacing:0.5px">
                {{ trans('email.inquiry_notification.reply_button', ['name' => $inquiry->name], $locale) }}
            </a>
        </td>
    </tr>
</table>

<p style="margin:0 0 4px;font-size:12px;color:#aaaaaa;text-align:center">{{ trans('email.inquiry_notification.link_hint', [], $locale) }}</p>
<p style="margin:0 0 24px;font-size:11px;color:#cccccc;text-align:center;word-break:break-all">{{ $replyUrl }}</p>

<p style="margin:24px 0 0;font-size:14px;color:#555555">
    {{ trans('email.common.closing', [], $locale) }}<br>
    <strong style="color:#1a1a1a">Fælled United</strong>
</p>

@endsection
