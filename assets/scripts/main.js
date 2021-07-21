import App from '@scripts/App.vue'
import i18n from '@scripts/i18n'
import Math from '@scripts/mathjs'
import router from '@scripts/router'
import Sentry from '@scripts/sentry'
import store from '@scripts/store'

import 'bootstrap'
import 'core-js'
import { DateTime } from 'luxon'
import { encode } from 'morsee'
import { createApp } from 'vue'

require.context('@images', true)

const app = createApp(App)
app.config.globalProperties.$dt = DateTime
app.config.globalProperties.$m = Math
app.config.globalProperties.$morse = text => encode(text)
app.config.globalProperties.$dms = deg => `${Math.fix(Math.abs(deg))}° ${Math.fix((Math.abs(deg) % 1) * 60)}'
  ${Math.round((((Math.abs(deg) % 1) * 60) % 1) * 60, 2)}"`

app.use(Sentry)
app.use(i18n)
app.use(router)
app.use(store)
app.mount('#app')
