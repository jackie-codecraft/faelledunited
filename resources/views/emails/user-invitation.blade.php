@extends('emails.layout')

@section('content')
<p style="font-size:16px;color:#374151;margin:0 0 16px;">
    {{ trans('email.invite.greeting', ['name' => $userName], $locale) }}
</p>
<p style="font-size:15px;color:#4b5563;margin:0 0 24px;line-height:1.6;">
    {{ trans('email.invite.body', [], $locale) }}
</p>

<!-- CTA button -->
<div style="text-align:center;margin:32px 0;">
    <a href="{{ $inviteUrl }}"
       style="display:inline-block;background:#1a472a;color:#ffffff;font-size:16px;
              font-weight:600;padding:14px 32px;border-radius:8px;text-decoration:none;
              letter-spacing:0.02em;">
        {{ trans('email.invite.cta', [], $locale) }}
    </a>
</div>

<p style="font-size:13px;color:#9ca3af;margin:24px 0 8px;">
    {{ trans('email.invite.link_hint', [], $locale) }}
</p>
<p style="font-size:12px;color:#6b7280;word-break:break-all;margin:0 0 24px;">
    {{ $inviteUrl }}
</p>
<p style="font-size:13px;color:#9ca3af;margin:0;">
    {{ trans('email.invite.expiry', [], $locale) }}
</p>
@endsection
