import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Content-Security-Policy'] = "default-src 'self'; frame-ancestors 'none'";
window.axios.defaults.headers.common['X-Content-Type-Options'] = 'nosniff';
window.axios.defaults.headers.common['X-Frame-Options'] = 'DENY';
window.axios.defaults.headers.common['X-XSS-Protection'] = '1; mode=block';
window.axios.defaults.headers.common['Referrer-Policy'] = 'strict-origin-when-cross-origin';
window.axios.defaults.headers.common['Strict-Transport-Security'] = 'max-age=31536000; includeSubDomains; preload';
window.axios.defaults.headers.common['Feature-Policy'] = "geolocation 'none'; midi 'none'; notifications 'none'; push 'none'; sync-xhr 'none'; microphone 'none'; camera 'none'; magnetometer 'none'; gyroscope 'none'; speaker 'none'; vibrate 'none'; fullscreen 'none'; payment 'none'; usb 'none'";
window.axios.defaults.headers.common['Permissions-Policy'] = "geolocation=(), microphone=(), camera=(), midi=(), encrypted-media=()";

import Logo from '../images/logo1.png'

const setFavicon = () => {
    let link = document.querySelector("link[rel*='icon']") || document.createElement('link');
    // link.type = 'image/png';
    link.type = 'image/png';
    link.rel = 'shortcut icon';
    link.href = Logo;
    document.getElementsByTagName('head')[0].appendChild(link);
}

setFavicon()
