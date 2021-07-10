import Client from '@scripts/services/open-weather-map/client'

class AircraftState {
  static getWeather (params) {
    return new Promise((resolve, reject) => {
      Client.get('/data/2.5/weather', params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }
}

export default AircraftState
