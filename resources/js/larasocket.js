import Echo from 'laravel-echo';
import Larasocket from 'larasocket-js';

window.Echo = new Echo({
    broadcaster: Larasocket,
    // token: process.env.MIX_LARASOCKET_TOKEN,
    token: "3324|07Jc0XGeN5nGyItGvbPG7gYVTc30wUWlUVgy41JV",

});
