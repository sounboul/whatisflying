import Client from '@scripts/services/api/client'

class Airline {
  static getAircraft (icaoCode, params) {
    return new Promise((resolve, reject) => {
      Client.get(`/airlines/${icaoCode}/aircraft`, params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static getAirline (icaoCode, params) {
    return new Promise((resolve, reject) => {
      Client.get(`/airlines/${icaoCode}`, params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static getAirlines (params) {
    return new Promise((resolve, reject) => {
      Client.get('/airlines', params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static getFlights (icaoCode, params) {
    return new Promise((resolve, reject) => {
      Client.get(`/airlines/${icaoCode}/flights`, params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }
}

export default Airline
