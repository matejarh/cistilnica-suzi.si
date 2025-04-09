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
                background: radial-gradient(circle, rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0.3));
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                animation: float 6s infinite ease-in-out;
                z-index: -1;
            }
            @keyframes float {
                0% {
                    transform: translateY(100vh); /* Start below the viewport */
                    opacity: 0.8;
                }
                50% {
                    opacity: 1;
                }
                100% {
                    transform: translateY(-100vh); /* Float above the viewport */
                    opacity: 0.8;
                }
            }
        </style>
    </head>
    <body id="container" >
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title">
                    @yield('message')
                </div>
            </div>
        </div>

        <!-- Floating bubbles -->
        <script>
            const setFavicon = () => {
                const link = document.querySelector("link[rel*='icon']") || document.createElement('link');
                link.type = 'image/png';
                link.rel = 'shortcut icon';
                link.href = 'favicon.png'; // Direct path to the favicon
                document.head.appendChild(link);
            };

            setFavicon();
            const container = document.getElementById("container");


            // Clear all existing bubbles
            const existingBubbles = container.getElementsByClassName("bubble");
            while (existingBubbles.length > 0) {
                existingBubbles[0].remove();
            }

            document.addEventListener("DOMContentLoaded", function () {
                for (let i = 0; i < 10; i++) {
                    let bubble = document.createElement("div");
                    bubble.className = "bubble";
                    let size = Math.random() * 60 + 20; // Random size between 20px and 80px
                    bubble.style.width = `${size}px`;
                    bubble.style.height = `${size}px`;
                    bubble.style.left = `${Math.random() * 100}vw`; // Random horizontal position
                    bubble.style.bottom = `${Math.random() * 100}vh`; // Start within the viewport height
                    bubble.style.animationDuration = `${Math.random() * 5 + 3}s`; // Random animation duration
                    bubble.style.animationDelay = `${Math.random() * 2}s`; // Random animation delay
                    document.body.appendChild(bubble);
                }
            });
        </script>
    </body>
</html>
