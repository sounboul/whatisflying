<template>

  <div v-if="success" class="alert alert-success mb-3">
    <div class="d-flex align-items-center">
      <FontAwesomeIcon class="me-3" :icon="['far', 'circle-check']" size="3x" aria-hidden="true"/>
      {{ $t('your_account_has_been_created') }}
    </div>
  </div>

  <form class="row g-3">
    <div class="col-12">
      <label class="form-label" for="email">{{ $t('label.email') }}</label>
      <input class="form-control" :class="{ 'is-invalid': violations.email }"
             id="email" type="email" :placeholder="$t('enter_your_email_address')"
             v-model="data.email" @input="delete violations.email">
      <div class="invalid-feedback">
        <div v-for="violation in violations.email" :key="violation.code">
          {{ violation.message }}
        </div>
      </div>
    </div>
    <div class="col-12">
      <label class="form-label" for="username">{{ $t('label.username') }}</label>
      <input class="form-control" :class="{ 'is-invalid': violations.username }"
             id="username" type="text" :placeholder="$t('choose_a_username')"
             v-model="data.username" @input="delete violations.username">
      <div class="invalid-feedback">
        <div v-for="violation in violations.username" :key="violation.code">
          {{ violation.message }}
        </div>
      </div>
    </div>
    <div class="col-12">
      <label class="form-label" for="password">{{ $t('label.password') }}</label>
      <input class="form-control" :class="{ 'is-invalid': violations.plainPassword }"
             id="password" type="password" :placeholder="$t('choose_a_password')"
             v-model="data.plainPassword" @input="delete violations.plainPassword">
      <div class="invalid-feedback">
        <div v-for="violation in violations.plainPassword" :key="violation.code">
          {{ violation.message }}
        </div>
      </div>
    </div>
    <div class="col-12">
      <label class="form-label" for="plainPasswordConfirmation">{{ $t('label.password_confirmation') }}</label>
      <input class="form-control" :class="{ 'is-invalid': violations.plainPasswordConfirmation }"
             id="plainPasswordConfirmation" type="password" :placeholder="$t('confirm_your_password')"
             v-model="data.plainPasswordConfirmation" @input="delete violations.plainPasswordConfirmation">
      <div class="invalid-feedback">
        <div v-for="violation in violations.plainPasswordConfirmation" :key="violation.code">
          {{ violation.message }}
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="form-check">
        <input class="form-check-input" :class="{ 'is-invalid': violations.privacyPolicy }"
               id="privacyPolicy" type="checkbox"
               v-model="data.privacyPolicy" @change="delete violations.privacyPolicy">
        <label class="form-check-label" for="privacyPolicy">
          <i18n-t keypath="i_agree_with_the_terms_of_the_privacy_policy">
            <template #link>
              <RouterLink :to="{ name: 'privacy_policy' }">
                {{ $t('privacy_policy') }}
              </RouterLink>
            </template>
          </i18n-t>
        </label>
      </div>
    </div>
    <div class="col-12 text-center">
      <button class="btn btn-outline-primary" type="button" :disabled="disabled" @click="submit">
        {{ $t('sign_up') }}
      </button>
    </div>
  </form>
</template>

<script>
import FontAwesomeIcon from '@scripts/fontawesome'
import { getViolations, UnprocessableEntity, User } from '@scripts/services/api'

export default {
  name: 'SignUpForm',
  components: {
    FontAwesomeIcon
  },
  methods: {
    submit () {
      this.disabled = true
      this.success = false
      this.violations = {}

      User.register(this.data).then(() => {
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
  watch: {
    '$i18n.locale': {
      immediate: true,
      handler (locale) {
        this.data.locale = locale
      }
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
