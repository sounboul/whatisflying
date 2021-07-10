import Client from '@scripts/services/api/client'

class Flight {
  static getFlight (flightNumber, params) {
    return new Promise((resolve, reject) => {
      Client.get(`/flights/${flightNumber}`, params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static getFlights (params) {
    return new Promise((resolve, reject) => {
      Client.get('/flights', params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }
}

export default Flight
