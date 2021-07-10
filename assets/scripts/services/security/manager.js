import { Unauthorized, User } from '@scripts/services/api'
import { AccountDisabled, AccountLocked, InvalidCredentials } from '@scripts/services/security/errors'
import store from '@scripts/store'

class Manager {
  static login (data) {
    return new Promise((resolve, reject) => {
      User.login(data).then(token => {
        store.dispatch('setToken', token)
        User.getCurrentUser().then(user => {
          store.dispatch('setUser', user)
          resolve(user)
        }).catch(error => {
          reject(error)
        })
      }).catch(error => {
        if (error instanceof Unauthorized) {
          const { message } = error.response.data
          if (message === 'Account disabled') {
            reject(new AccountDisabled(error.response))
          } else if (message === 'Account locked') {
            reject(new AccountLocked(error.response))
          } else {
            reject(new InvalidCredentials(error.response))
          }
        }

        reject(error)
      })
    })
  }

  static logout () {
    store.dispatch('setToken', null)
    store.dispatch('setUser', null)
  }
}

export default Manager
