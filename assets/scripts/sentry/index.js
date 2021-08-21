import router from '@scripts/router'
import store from '@scripts/store'
import { BrowserTracing } from '@sentry/tracing/esm/browser'
import { captureException, init, setTag, setUser, vueRouterInstrumentation } from '@sentry/vue'

export default {
  install: app => {
    init({
      app,
      debug: process.env.NODE_ENV === 'development',
      dsn: process.env.SENTRY_DSN,
      ignoreErrors: [
        /^Network error$/i,
        /^Request aborted$/i,
        /^ResizeObserver/i
      ],
      integrations: [
        new BrowserTracing({
          routingInstrumentation: vueRouterInstrumentation(router),
          tracingOrigins: [/^(dev\.)?whatisflying\.com/]
        })
      ],
      release: `whatisflying@${process.env.NPM_PACKAGE_VERSION}`,
      tracesSampleRate: 1.0
    })

    setTag('locale', store.getters.locale)
    setUser(store.getters.user)

    app.config.errorHandler = (error, component, info) => {
      if (process.env.NODE_ENV === 'development') {
        console.error(error)
      }

      setTag('info', info)
      captureException(error)
    }
  }
}
