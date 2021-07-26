import Client from '@scripts/services/here/client'

class Geocode {
  static search (params) {
    return new Promise((resolve, reject) => {
      Client.get('https://geocode.search.hereapi.com/v1/geocode', params).then(response => {
        const results = response.data?.items || []
        resolve(results)
      }).catch(error => {
        reject(error)
      })
    })
  }
}

export default Geocode
