<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Čistilnica Suzi')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* background: linear-gradient(to bottom, #0ea5e9, #7dd3fc); */
            color: #ffffff;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
            position: relative;
            background: linear-gradient(to bottom, #0ea5e9, #7dd3fc);
            padding: 20px;
        }
        .wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            color: #334155;
            z-index: 1;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            background-color: #0ea5e9;
            color: #ffffff;
            border-radius: 8px 8px 0 0;
        }
        .header img {
            max-height: 80px;
            margin-bottom: 10px;
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
            color: #ffffff !important;
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
        .bubbles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }
        .bubble {
            position: absolute;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0.3));
            border-radius: 50%;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <!-- Static Bubbles -->
    <div class="wrapper">
        <div class="bubbles">
            <div class="bubble" style="width: 40px; height: 40px; left: 10%; top: 20%;"></div>
            <div class="bubble" style="width: 60px; height: 60px; left: 30%; top: 50%;"></div>
            <div class="bubble" style="width: 50px; height: 50px; left: 70%; top: 10%;"></div>
            <div class="bubble" style="width: 30px; height: 30px; left: 50%; top: 80%;"></div>
            <div class="bubble" style="width: 70px; height: 70px; left: 90%; top: 40%;"></div>
        </div>
        <div class="container">
            <div class="header">
                <img src="{{ asset('images/logoSuzi150.png') }}" alt="Čistilnica Suzi Logo" onerror="this.style.display='none';">
                <h1>@yield('header-title', 'Čistilnica Suzi')</h1>
            </div>
            <div class="content">
                @yield('content')
            </div>
            <div class="footer">
                <p>@yield('footer-text', 'Čistilnica Suzi - brezhibna čistoča za vaše perilo.')</p>
            </div>
        </div>

    </div>

</body>
</html>
