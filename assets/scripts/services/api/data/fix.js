import Client from '@scripts/services/api/client'

class Fix {
  static getFix (slug, params) {
    return new Promise((resolve, reject) => {
      Client.get(`/fixes/${slug}`, params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static getFixes (params) {
    return new Promise((resolve, reject) => {
      Client.get('/fixes', params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }
}

export default Fix
