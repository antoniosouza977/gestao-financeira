import './bootstrap';
import '../css/app.css';

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy';
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import "vue-toastification/dist/index.css";
import Toast from "vue-toastification";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';


import '@/Assets/styles.scss';
import '@/Assets/tailwind.css';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        return createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                theme: {
                    preset: Aura,
                    options: {
                        darkModeSelector: '.app-dark'
                    }
                }
            })
            .use(Toast)
            .use(VueSweetalert2, {
                confirmButtonColor: '#34D399',
                cancelButtonColor: '#ff7674',
                showCancelButton: true,
                confirmButtonText: "Sim",
                cancelButtonText: "Cancelar",
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
