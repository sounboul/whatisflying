import store from '@scripts/store'
import { DateTime, Settings } from 'luxon'

Settings.defaultLocale = store.getters.locale

export default DateTime
