<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>@yield('title', 'Fælled United')</title>
</head>
<body style="margin:0;padding:0;background-color:#f0f0f0;font-family:Arial,Helvetica,sans-serif;color:#1a1a1a">

    {{-- Header --}}
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

    {{-- Body --}}
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center" style="padding:32px 20px">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:580px">
                    <tr>
                        <td bgcolor="#ffffff" style="padding:40px 40px 32px;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08)">
                            @yield('content')
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- Footer --}}
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center" style="padding:0 20px 40px">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:580px">
                    <tr>
                        <td align="center" style="padding:20px 0 0;border-top:1px solid #e0e0e0;color:#888888;font-size:12px;line-height:1.6">
                            <strong style="color:#1a472a">Fælled United</strong><br>
                            Ørestad, København S · 2300<br>
                            <a href="{{ config('app.url') }}" style="color:#1a472a;text-decoration:none">faelledunited.dk</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>
