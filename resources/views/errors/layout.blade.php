<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Styles -->
        <style>
            html, body {
                color: white;
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                font-weight: 100;
                height: 100vh;
                margin: 0;

            }

            body {
                background: linear-gradient(to bottom, #0ea5e9, #7dd3fc);
                overflow: hidden;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 36px;
                padding: 20px;
            }
            .bubble {
                position: absolute;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                animation: float 6s infinite ease-in-out;
            }
            @keyframes float {
                0% { transform: translateY(0); opacity: 0.8; }
                50% { transform: translateY(-20px); opacity: 1; }
                100% { transform: translateY(0); opacity: 0.8; }
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title">
                    @yield('message')
                </div>
            </div>
        </div>

        <!-- Floating bubbles -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            for (let i = 0; i < 10; i++) {
                let bubble = document.createElement("div");
                bubble.className = "bubble";
                let size = Math.random() * 60 + 20;
                bubble.style.width = `${size}px`;
                bubble.style.height = `${size}px`;
                bubble.style.left = `${Math.random() * 100}vw`;
                bubble.style.bottom = `-${size}px`;
                bubble.style.animationDuration = `${Math.random() * 5 + 3}s`;
                document.body.appendChild(bubble);
            }
        });
    </script>
    </body>
</html>
