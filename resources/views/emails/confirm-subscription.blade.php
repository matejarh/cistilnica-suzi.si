<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Potrdi prijavo na akcije</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
            background-color: #0ea5e9;
            color: #ffffff;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
            text-align: center;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #0ea5e9;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #94a3b8;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Potrdite svojo prijavo na akcije</h1>
        </div>
        <div class="content">
            <p>Hvala, ker ste se prijavili na naše novice! Za dokončanje prijave prosimo, da potrdite svoj e-poštni naslov s klikom na spodnji gumb.</p>
            <a href="{!! url("/potrditev-prijave-na-promocije?token={$token}&email={$email}") !!}" class="button">Potrdi naročnino</a>
            <p>Če povezava ne deluje, kopirajte in prilepite naslednji URL v svoj brskalnik:</p>
            <p>{!! url("/potrditev-prijave-na-promocije?token={$token}&email={$email}") !!}</p>
        </div>
        <div class="footer">
            <p>Čistilnica Suzi - brezhibna čistoča za vaše perilo.</p>
        </div>
    </div>
</body>
</html>
