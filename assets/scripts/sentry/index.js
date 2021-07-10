import store from '@scripts/store'
import { captureException, init, setTag, setUser } from '@sentry/browser'
import { BrowserTracing } from '@sentry/tracing/esm/browser'

export default {
  name: 'Sentry',
  install: app => {
    init({
      debug: process.env.NODE_ENV === 'development',
      dsn: process.env.SENTRY_DSN,
      ignoreErrors: [
        /^Network error$/i,
        /^Request aborted$/i,
        /^ResizeObserver/i
      ],
      integrations: [
        new BrowserTracing({
          tracingOrigins: [
            /^(dev\.)?whatisflying\.com/
          ]
        })
      ],
      release: process.env.NPM_PACKAGE_VERSION,
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
