import Client from '@scripts/services/api/client'

class Aircraft {
  static getAircraft (icao24bitAddress, params) {
    return new Promise((resolve, reject) => {
      Client.get(`/aircraft/${icao24bitAddress}`, params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static getAircrafts (params) {
    return new Promise((resolve, reject) => {
      Client.get('/aircraft', params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }
}

export default Aircraft
