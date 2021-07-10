import Client from '@scripts/services/api/client'

class Message {
  static deleteMessage (id) {
    return new Promise((resolve, reject) => {
      Client.delete(`/messages/${id}`).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static getMessage (id, params) {
    return new Promise((resolve, reject) => {
      Client.get(`/messages/${id}`, params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static getMessages (params) {
    return new Promise((resolve, reject) => {
      Client.get('/messages', params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static send (params) {
    return new Promise((resolve, reject) => {
      Client.post('/messages', params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }
}

export default Message
