import Client from '@scripts/services/api/client'

class User {
  static activateAccount (id, data) {
    return new Promise((resolve, reject) => {
      Client.post(`/users/${id}/activate-account`, data).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static deleteAccount (id, data) {
    return new Promise((resolve, reject) => {
      Client.post(`/users/${id}/delete-account`, data).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static getCurrentUser () {
    return new Promise((resolve, reject) => {
      Client.get('/users/current-user').then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static getUsers (params) {
    return new Promise((resolve, reject) => {
      Client.get('/users', params).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static lockAccount (id) {
    return new Promise((resolve, reject) => {
      Client.post(`/users/${id}/lock-account`, {}).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static login (data) {
    return new Promise((resolve, reject) => {
      Client.post('/login', data).then(response => {
        const { token: authenticationToken, refresh_token: refreshToken } = response.data
        resolve({ authenticationToken, refreshToken })
      }).catch(error => {
        reject(error)
      })
    })
  }

  static register (data) {
    return new Promise((resolve, reject) => {
      Client.post('/users', data).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static requestPasswordReset (data) {
    return new Promise((resolve, reject) => {
      Client.post('/users/request-password-reset', data).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static resetPassword (id, data) {
    return new Promise((resolve, reject) => {
      Client.post(`/users/${id}/reset-password`, data).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static unlockAccount (id) {
    return new Promise((resolve, reject) => {
      Client.post(`/users/${id}/unlock-account`, {}).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static updateLocale (id, data) {
    return new Promise((resolve, reject) => {
      Client.put(`/users/${id}/locale`, data).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }

  static updatePassword (id, data) {
    return new Promise((resolve, reject) => {
      Client.put(`/users/${id}/password`, data).then(response => {
        resolve(response.data)
      }).catch(error => {
        reject(error)
      })
    })
  }
}

export default User
