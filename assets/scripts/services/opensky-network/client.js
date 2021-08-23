import { getErrorFromResponse } from '@scripts/http-errors'
import { captureException } from '@sentry/vue'
import Axios from 'axios'

const MAX_RETRIES = 3

const Client = Axios.create({
  baseURL: 'https://opensky-network.org/api/',
  timeout: 5000,
  headers: {
    authorization: `Basic ${process.env.OPENSKY_NETWORK_API_KEY}`
  }
})

Client.interceptors.response.use(response => response, error => new Promise((resolve, reject) => {
  if (Axios.isCancel(error)) {
    return
  }

  if (!error.response || error.response?.status >= 500) {
    if (!error.config.retries || error.config?.retries < MAX_RETRIES) {
      error.config.retries = (error.config.retries || 0) + 1
      Client.request(error.config).then(resolve, reject).catch(error => reject(error))
      return
    }
  }

  if (error.response) {
    reject(getErrorFromResponse(error.response))
  }

  if (error.message.match(/timeout/)) {
    captureException(error)
    return
  }

  reject(error)
}))

export default Client
