import Client from '@scripts/services/api/client'

class Airport {
  static getAirport (icaoCode, params) {
    return new Promise((resolve, reject) => {
      Client.get(`/airports/${icaoCode}`, params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static getAirportDatasets (icaoCode, params) {
    return new Promise((resolve, reject) => {
      Client.get(`/airports/${icaoCode}/datasets`, params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static getAirportFrequencies (icaoCode, params) {
    return new Promise((resolve, reject) => {
      Client.get(`/airports/${icaoCode}/frequencies`, params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static getAirportRunways (icaoCode, params) {
    return new Promise((resolve, reject) => {
      Client.get(`/airports/${icaoCode}/runways`, params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static getAirports (params) {
    return new Promise((resolve, reject) => {
      Client.get('/airports', params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }
}

export default Airport
