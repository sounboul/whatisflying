<template>

  <div v-if="success" class="alert alert-success mb-3">
    <div class="d-flex align-items-center">
      <FontAwesomeIcon class="me-3" :icon="['far', 'circle-check']" size="3x" aria-hidden="true"/>
      {{ $t('your_password_has_been_updated') }}
    </div>
  </div>

  <form class="row g-3">
    <div class="col-12">
      <label class="form-label" for="plainPassword">{{ $t('label.new_password') }}</label>
      <input class="form-control" :class="{ 'is-invalid': violations.plainPassword }"
             id="plainPassword" type="password" :placeholder="$t('choose_a_new_password')"
             v-model="data.plainPassword" @input="delete violations.plainPassword">
      <div class="invalid-feedback">
        <div v-for="violation in violations.plainPassword" :key="violation.code">
          {{ violation.message }}
        </div>
      </div>
    </div>
    <div class="col-12">
      <label class="form-label" for="plainPasswordConfirmation">{{ $t('label.new_password_confirmation') }}</label>
      <input class="form-control" :class="{ 'is-invalid': violations.plainPasswordConfirmation }"
             id="plainPasswordConfirmation" type="password" :placeholder="$t('confirm_your_new_password')"
             v-model="data.plainPasswordConfirmation" @input="delete violations.plainPasswordConfirmation">
      <div class="invalid-feedback">
        <div v-for="violation in violations.plainPasswordConfirmation" :key="violation.code">
          {{ violation.message }}
        </div>
      </div>
    </div>
    <div class="col-12">
      <label class="form-label" for="currentPassword">{{ $t('label.current_password') }}</label>
      <input class="form-control" :class="{ 'is-invalid': violations.currentPassword }"
             id="currentPassword" type="password" :placeholder="$t('enter_your_current_password')"
             v-model="data.currentPassword" @input="delete violations.currentPassword">
      <div class="invalid-feedback">
        <div v-for="violation in violations.currentPassword" :key="violation.code">
          {{ violation.message }}
        </div>
      </div>
    </div>
    <div class="col-12 text-center">
      <button class="btn btn-outline-primary" type="button" :disabled="disabled" @click="submit">
        {{ $t('update_password') }}
      </button>
    </div>
  </form>
</template>

<script>
import FontAwesomeIcon from '@scripts/fontawesome'
import { getViolations, UnprocessableEntity, User } from '@scripts/services/api'
import { mapGetters } from 'vuex'

export default {
  name: 'UpdatePasswordForm',
  components: {
    FontAwesomeIcon
  },
  computed: {
    ...mapGetters(['user'])
  },
  methods: {
    submit () {
      this.disabled = true
      this.success = false
      this.violations = {}

      User.updatePassword(this.user?.id, this.data).then(() => {
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
