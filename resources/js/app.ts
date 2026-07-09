import { library } from '@fortawesome/fontawesome-svg-core';
import {
    faBuilding,
    faTachographDigital,
    faEnvelope,
    faCalendarDays,
} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { createInertiaApp } from '@inertiajs/vue3';
import { initializeTheme } from '@/composables/useAppearance';
import AppLayout from '@/layouts/AppLayout.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { initializeFlashToast } from '@/lib/flashToast';

library.add(faBuilding, faTachographDigital, faEnvelope, faCalendarDays);
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    defaults: {
        visitOptions: (href, options) => {
            return { viewTransition: true };
        },
    },
    title: (title) => (title ? `${title} - ${appName}` : appName),
    layout: (name) => {
        switch (true) {
            case name === 'Welcome':
                return null;
            case name.startsWith('auth/'):
                return AuthLayout;
            case name.startsWith('settings/'):
                return [AppLayout, SettingsLayout];
            default:
                return AppLayout;
        }
    },
    progress: {
        color: '#4B5563',
    },
    withApp: function (app) {
        // @ts-expect-error - below code is too complex to expand
        app.component('font-awesome-icon', FontAwesomeIcon);
    },
}).then((r) => console.log(r));

// This will set light / dark mode on page load...
initializeTheme();

// This will listen for flash toast data from the server...
initializeFlashToast();
