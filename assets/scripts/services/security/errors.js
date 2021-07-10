import { Unauthorized } from '@scripts/http-errors'

export class AccountDisabled extends Unauthorized {
  constructor (response, message = 'Account disabled') {
    super(response, message, 401)
  }
}

export class AccountLocked extends Error {
  constructor (response, message = 'Account locked') {
    super(response, message, 401)
  }
}

export class InvalidCredentials extends Error {
  constructor (response, message = 'Invalid credentials') {
    super(response, message, 401)
  }
}
