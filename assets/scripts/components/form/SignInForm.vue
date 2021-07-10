<template>

  <div v-if="error" class="alert alert-danger mb-3">
    <div class="d-flex align-items-center">
      <FontAwesomeIcon class="me-3" :icon="['far', 'circle-exclamation']" size="3x" aria-hidden="true"/>
      {{ error }}
    </div>
  </div>

  <form class="row g-3">
    <div class="col-12">
      <label class="form-label" for="inputUsername">{{ $t('label.username') }}</label>
      <input class="form-control" id="inputUsername" type="text"
             :placeholder="$t('enter_your_username')" v-model="data.username"
             @input="invalidCredentials = false">
    </div>
    <div class="col-12">
      <label class="form-label" for="inputPassword">{{ $t('label.password') }}</label>
      <input class="form-control" id="inputPassword" type="password"
             :placeholder="$t('enter_your_password')" v-model="data.password"
             @input="invalidCredentials = false">
      <div class="form-text">
        <RouterLink :to="{ name: 'request_password_reset' }">{{ $t('forgotten_password') }}</RouterLink>
      </div>
    </div>
    <div class="col-12 text-center">
      <button class="btn btn-outline-primary" type="button" :disabled="disabled" @click="submit">
        {{ $t('sign_in') }}
      </button>
    </div>
  </form>
</template>

<script>
import FontAwesomeIcon from '@scripts/fontawesome'
import { AccountDisabled, AccountLocked, BadRequest, InvalidCredentials, Security } from '@scripts/services/security'

export default {
  name: 'SignInForm',
  components: {
    FontAwesomeIcon
  },
  methods: {
    submit () {
      this.disabled = true
      this.error = null

      Security.login(this.data).catch(error => {
        if (error instanceof BadRequest || error instanceof InvalidCredentials) {
          this.error = this.$t('invalid_credentials')
          return
        } else if (error instanceof AccountDisabled) {
          this.error = this.$t('account_disabled')
          return
        } else if (error instanceof AccountLocked) {
          this.error = this.$t('account_locked')
          return
        }

        throw error
      }).finally(() => {
        this.disabled = false
      })
    }
  },
  data () {
    return {
      data: {},
      disabled: false,
      error: null
    }
  }
}
</script>
