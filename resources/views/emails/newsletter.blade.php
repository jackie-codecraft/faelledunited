@extends('emails.layout')

@section('title', $newsletter->subject)

@section('content')

<h2 style="margin:0 0 8px;font-size:22px;color:#0f2718;font-weight:bold">{{ $newsletter->subject }}</h2>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<div style="font-size:15px;color:#333333;line-height:1.6">
    {!! $newsletter->body !!}
</div>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:24px;margin-bottom:16px">
    <tr><td style="border-top:1px solid #eeeeee"></td></tr>
</table>

<p style="margin:0;font-size:12px;color:#aaaaaa;line-height:1.6;text-align:center">
    {{ trans('email.newsletter.footer', ['email' => config('mail.from.address')], $locale) }}
</p>

@endsection
