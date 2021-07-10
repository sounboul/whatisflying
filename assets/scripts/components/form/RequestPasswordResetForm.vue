<template>

  <div v-if="success" class="alert alert-success mb-3">
    <div class="d-flex align-items-center">
      <FontAwesomeIcon class="me-3" :icon="['far', 'circle-check']" size="3x" aria-hidden="true"/>
      {{ $t('you_will_receive_an_email_with_instructions_to_reset_your_password') }}
    </div>
  </div>

  <form class="row g-3">
    <div class="col-12">
      <label class="form-label" for="email">{{ $t('label.email') }}</label>
      <input class="form-control" :class="{ 'is-invalid': violations.email }"
             id="email" type="text"
             v-model="data.email" @input="delete violations.email">
      <div class="invalid-feedback">
        <div v-for="violation in violations.email" :key="violation.code">
          {{ violation.message }}
        </div>
      </div>
    </div>
    <div class="col-12 text-center">
      <button class="btn btn-outline-primary" type="button" :disabled="disabled" @click="submit">
        {{ $t('reset_password') }}
      </button>
    </div>
  </form>
</template>

<script>
import FontAwesomeIcon from '@scripts/fontawesome'
import { getViolations, UnprocessableEntity, User } from '@scripts/services/api'

export default {
  name: 'RequestPasswordResetForm',
  components: {
    FontAwesomeIcon
  },
  methods: {
    submit () {
      this.disabled = true
      this.success = false
      this.violations = {}

      User.requestPasswordReset(this.data).then(() => {
        this.success = true
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
      success: false,
      violations: {}
    }
  }
}
</script>
