<template>
  <form class="row g-3">
    <div class="col-12">
      <label class="form-label" for="currentPassword">{{ $t('label.password') }}</label>
      <input class="form-control" :class="{ 'is-invalid': violations.currentPassword }"
             id="currentPassword" type="password" :placeholder="$t('enter_your_password')"
             v-model="data.currentPassword" @input="delete violations.currentPassword">
      <div class="invalid-feedback">
        <div v-for="violation in violations.currentPassword" :key="violation.code">
          {{ violation.message }}
        </div>
      </div>
    </div>
    <div class="col-12 text-center">
      <button class="btn btn-outline-primary" type="button" :disabled="disabled" @click="submit">
        {{ $t('delete_account') }}
      </button>
    </div>
  </form>
</template>

<script>
import { getViolations, UnprocessableEntity, User } from '@scripts/services/api'
import Security from '@scripts/services/security'
import { mapGetters } from 'vuex'

export default {
  name: 'DeleteAccountForm',
  computed: {
    ...mapGetters(['user'])
  },
  methods: {
    submit () {
      this.disabled = true
      this.violations = {}

      User.deleteAccount(this.user?.id, this.data).then(() => {
        Security.logout()
      }).catch(error => {
        if (error instanceof UnprocessableEntity) {
          this.violations = getViolations(error.response.data)
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
      violations: {}
    }
  }
}
</script>
