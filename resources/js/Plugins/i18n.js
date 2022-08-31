import {
    createI18n
} from 'vue-i18n'
import axios from "axios";
import {
    Inertia
} from "@inertiajs/inertia";

export async function setupI18n(props) {
    const options = {
        locale: props.locale,
        fallbackLocale: props.fallbackLocale,
        messages: {},
        datetimeFormats: {}
    };
    for (const locale of props.locales) {
        const messages = await import(`../Locales/${locale}.json`);
        options.messages[locale] = messages
        options.datetimeFormats[locale] = messages.datetimeFormats;
    }
    const i18n = createI18n(options)
    setupInertia(i18n)
    setI18nLanguage(i18n, options.locale)
    return i18n
}

export function setI18nLanguage(i18n, locale) {
    if (i18n.mode === 'legacy') {
        i18n.global.locale = locale
    } else {
        i18n.global.locale.value = locale
    }
    axios.defaults.headers.common['Accept-Language'] = locale
    document.querySelector('html').setAttribute('lang', locale)
}

function setupInertia(i18n) {
    Inertia.on('before', async event => {
        console.log(event.detail);
    });
    Inertia.on('success', async event => {
        setI18nLanguage(i18n, event.detail.page.props.locale)
    })
}
