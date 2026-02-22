<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Preview: {{ $newsletter->subject }}</title>
    <style>
        body { margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background: #f0f0f0; }
        .preview-banner {
            background: #f59e0b;
            color: #1a1a1a;
            text-align: center;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.02em;
            position: sticky;
            top: 0;
            z-index: 9999;
        }
    </style>
</head>
<body>

<div class="preview-banner">
    ⚠️ This is a preview — this newsletter has not been sent yet
</div>

@extends('emails.layout')

<!-- Inline email body below -->
<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center" bgcolor="#0f2718" style="padding:32px 20px">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td align="center">
                        <img src="{{ url('/images/logo.jpg') }}"
                             width="56" height="56"
                             alt="Fælled United"
                             style="border-radius:50%;display:block;border:2px solid rgba(255,255,255,0.2)">
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding-top:12px">
                        <span style="color:#ffffff;font-size:20px;font-weight:bold;letter-spacing:3px;text-transform:uppercase">FÆLLED UNITED</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center" style="padding:32px 20px">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:580px">
                <tr>
                    <td bgcolor="#ffffff" style="padding:40px 40px 32px;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08)">
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
                            {{ __('email.newsletter.footer', ['email' => config('mail.from.address')]) }}
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
