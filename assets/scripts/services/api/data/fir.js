import Client from '@scripts/services/api/client'

class Fir {
  static getFirs (params) {
    return new Promise((resolve, reject) => {
      Client.get('/firs', params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }
}

export default Fir
