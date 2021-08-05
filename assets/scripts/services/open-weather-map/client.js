import { getErrorFromResponse } from '@scripts/http-errors'
import Axios from 'axios'

const MAX_RETRIES = 3

const Client = Axios.create({
  baseURL: 'https://api.openweathermap.org/',
  timeout: 5000,
  params: {
    appid: process.env.OPEN_WEATHER_MAP_API_KEY,
    units: 'metric'
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

  reject(error)
}))

export default Client
