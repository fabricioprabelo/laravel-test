/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import "flowbite";
import Lang from "lang.js";
import Inputmask from "inputmask";

Inputmask().mask(document.querySelectorAll("input"));

const lang = new Lang({
    messages,
    locale,
    fallback,
});

const $t = (key, arg1 = 0, arg2 = {}) => {
    if (typeof arg1 === "object") return lang.get(key, arg1);
    else if (typeof arg1 === "number" && typeof arg2 === "object")
        return lang.choice(key, arg1, arg2);
    else return lang.get(key);
};

window.$t = $t;

const capitalize = (str) => {
    return str.toLowerCase().replace(/^\w/, (c) => c.toUpperCase());
};

window.capitalize = capitalize;

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
