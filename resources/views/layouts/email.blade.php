<!DOCTYPE html>
<html lang="sl">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Čistilnica Suzi')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
</head>

<body style="margin: 0; padding: 0; font-family: Lato, sans-serif; background-color: #e0f2fe;">

    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #e0f2fe; padding: 20px;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0" role="presentation"
                    style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); overflow: hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background-color: #0ea5e9; padding: 20px; text-align: center; color: #ffffff;">
                            <img src="{{ asset('images/logoSuzi150.png') }}" alt="Čistilnica Suzi Logo"
                                style="max-height: 80px; display: block; margin: 0 auto 10px auto;"
                                onerror="this.style.display='none';">
                            <h1 style="margin: 0; font-size: 24px;">@yield('header-title', 'Čistilnica Suzi')</h1>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 20px; text-align: left; color: #334155; font-size: 16px; line-height: 1.5; max-width: 570px; text-align: center;">
                            @yield('content')
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr style="border-bottom: 1px solid #e0f2fe;">
                        <td style="text-align: center; font-size: 14px; color: #94a3b8; padding: 20px; ;">
                            <p style="margin: 0; display: inline-block;">@yield('footer-text', 'Čistilnica Suzi - brezhibna čistoča za vaše perilo.')</p>
                        </td>
                    </tr>
                    @hasSection('footer')
                        <tr>
                            <td style="text-align: center; font-size: 11px; color: #94a3b8; padding: 20px;">
                                <p style="margin: 0;">@yield('footer')</p>
                            </td>
                        </tr>
                    @endif

                </table>

            </td>
        </tr>
    </table>
</body>
</html>
