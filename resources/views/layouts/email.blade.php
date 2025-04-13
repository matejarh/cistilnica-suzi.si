<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Čistilnica Suzi')</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #e0f2fe;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #e0f2fe; padding: 20px;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td style="background-color: #0ea5e9; padding: 20px; border-radius: 8px 8px 0 0; text-align: center; color: #ffffff;">
                            <img src="{{ asset('images/logoSuzi150.png') }}" alt="Čistilnica Suzi Logo" style="max-height: 80px; display: block; margin: 0 auto 10px auto;" onerror="this.style.display='none';">
                            <h1 style="margin: 0; font-size: 24px;">@yield('header-title', 'Čistilnica Suzi')</h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 20px; text-align: center; color: #334155;">
                            @yield('content')
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center; font-size: 14px; color: #94a3b8; padding: 20px;">
                            <p style="margin: 0;">@yield('footer-text', 'Čistilnica Suzi - brezhibna čistoča za vaše perilo.')</p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>
</html>
