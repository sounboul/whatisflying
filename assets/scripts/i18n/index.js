import store from '@scripts/store'
import preferredLocale from 'preferred-locale'
import { createI18n } from 'vue-i18n'

const I18N_AVAILABLE_LOCALES = ['en', 'fr']
const I18N_FALLBACK_LOCALE = 'en'

const messages = {
  en: require('@scripts/i18n/translations/en.json'),
  fr: require('@scripts/i18n/translations/fr.json')
}

const i18n = createI18n({
  availableLocales: I18N_AVAILABLE_LOCALES,
  fallbackLocale: I18N_FALLBACK_LOCALE,
  locale: store.getters.locale || preferredLocale(I18N_AVAILABLE_LOCALES, I18N_FALLBACK_LOCALE),
  messages,
  modifiers: {
    label: str => `${str}:`
  }
})

export default i18n
