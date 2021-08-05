import { getErrorFromResponse } from '@scripts/http-errors'
import store from '@scripts/store'
import { captureException } from '@sentry/browser'
import Axios from 'axios'
import qs from 'qs'

const MAX_RETRIES = 3

const Client = Axios.create({
  baseURL: `${process.env.BASE_URL}/api`,
  timeout: 10000,
  headers: {
    accept: 'application/ld+json'
  },
  paramsSerializer: params => qs.stringify(params, {
    arrayFormat: 'brackets',
    encode: false,
    indices: false,
    skipNulls: true,
    filter: (prefix, value) => value !== '' ? value : undefined
  })
})

Client.interceptors.request.use(request => {
  request.headers['accept-language'] = store.getters.locale

  if (!('authorization' in request.headers) && request.url !== '/login') {
    if (store.getters.token) {
      const { authenticationToken } = store.getters.token
      request.headers.authorization = `Bearer ${authenticationToken}`
    }
  }

  return request
})

Client.interceptors.response.use(response => response, error => new Promise((resolve, reject) => {
  if (Axios.isCancel(error)) {
    return
  }

  if (error.response?.status === 401 && 'authorization' in error.config.headers) {
    if (store.getters.token) {
      const { refreshToken } = store.getters.token
      Axios.post('/api/refresh', { refresh_token: refreshToken }).then(response => {
        const { token: authenticationToken, refresh_token: refreshToken } = response.data
        store.dispatch('setToken', { authenticationToken, refreshToken })
        error.config.headers.authorization = `Bearer ${authenticationToken}`
        Client.request(error.config).then(resolve, reject).catch(error => reject(error))
      }).catch(error => reject(error))
      return
    }
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
