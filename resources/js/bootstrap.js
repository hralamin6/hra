import Echo from 'laravel-echo'
import Pusher from 'pusher-js';
window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'df0ae9dd2ba3285b8323',
    cluster: 'ap2',
    forceTLS: true
});
