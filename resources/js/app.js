// import './bootstrap';
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import {ZiggyVue} from 'ziggy'

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob("./Pages/**/*.vue", {eager: true});

        const page = pages[`./Pages/${name}.vue`];

        page.default.layout = page.default.layout || MainLayout;
        // return pages[`./Pages/${name}.vue`]
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el)
    },
})
