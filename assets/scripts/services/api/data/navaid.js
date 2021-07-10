import Client from '@scripts/services/api/client'

class Navaid {
  static getNavaid (slug, params) {
    return new Promise((resolve, reject) => {
      Client.get(`/navaids/${slug}`, params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static getNavaids (params) {
    return new Promise((resolve, reject) => {
      Client.get('/navaids', params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }
}

export default Navaid
