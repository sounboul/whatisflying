import Client from '@scripts/services/api/client'

class AircraftType {
  static getAircraftModels (icaoCode, params) {
    return new Promise((resolve, reject) => {
      Client.get(`/aircraft_types/${icaoCode}/aircraft_models`, params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static getAircraftType (icaoCode) {
    return new Promise((resolve, reject) => {
      Client.get(`/aircraft_types/${icaoCode}`).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static getAircraftTypes (params) {
    return new Promise((resolve, reject) => {
      Client.get('/aircraft_types', params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }
}

export default AircraftType
