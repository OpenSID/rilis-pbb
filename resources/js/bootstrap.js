import {isEmpty} from 'lodash';
import $ from 'jquery';
import * as bootstrap from 'bootstrap';
import {popper} from "@popperjs/core";
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'select2/dist/js/select2.full.min';
import 'datatables.net/js/jquery.dataTables.min';
import 'datatables.net-bs5/js/dataTables.bootstrap5.min';
import 'datatables.net-responsive-bs5/js/responsive.bootstrap5.min';
import 'datatables.net-searchpanes-bs5/js/searchPanes.bootstrap5.min';
import 'datatables.net-select-bs5/js/select.bootstrap5.min';
import 'datatables.net-searchbuilder-bs5/js/searchBuilder.bootstrap5.min';
import 'inputmask/dist/jquery.inputmask.min';
import 'daterangepicker/daterangepicker';

window.isEmpty = isEmpty;
window.$ = $;
window.jQuery = jQuery;
window.bootstrap = bootstrap
window.popper = popper;
window.Swal = Swal;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

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
