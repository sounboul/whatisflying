<template>

  <div v-if="success" class="alert alert-success mb-3">
    <div class="d-flex align-items-center">
      <FontAwesomeIcon class="me-3" :icon="['far', 'circle-check']" size="3x" aria-hidden="true"/>
      {{ $t('your_message_has_been_sent') }}
    </div>
  </div>

  <div class="row g-3">
    <div class="col-12">
      <label class="form-label" for="senderName">{{ $t('label.full_name') }}</label>
      <input class="form-control" :class="{ 'is-invalid': violations.senderName }"
             id="senderName" type="text" :placeholder="$t('enter_your_full_name')"
             v-model="data.senderName" @input="delete violations.senderName">
      <div class="invalid-feedback">
        <div v-for="violation in violations.senderName" :key="violation.code">
          {{ violation.message }}
        </div>
      </div>
    </div>
    <div class="col-12">
      <label class="form-label" for="senderAddress">{{ $t('label.email') }}</label>
      <input class="form-control" :class="{ 'is-invalid': violations.senderAddress }"
             id="senderAddress" type="email" :placeholder="$t('enter_your_email_address')"
             v-model="data.senderAddress" @input="delete violations.senderAddress">
      <div class="invalid-feedback">
        <div v-for="violation in violations.senderAddress" :key="violation.code">
          {{ violation.message }}
        </div>
      </div>
    </div>
    <div class="col-12">
      <label class="form-label" for="subject">{{ $t('label.subject') }}</label>
      <input class="form-control" :class="{ 'is-invalid': violations.subject }"
             id="subject" type="text" :placeholder="$t('enter_the_subject_of_your_message')"
             v-model="data.subject" @input="delete violations.subject">
      <div class="invalid-feedback">
        <div v-for="violation in violations.subject" :key="violation.code">
          {{ violation.message }}
        </div>
      </div>
    </div>
    <div class="col-12">
      <label class="form-label" for="message">{{ $t('label.message') }}</label>
      <textarea class="form-control" :class="{ 'is-invalid': violations.message }"
                id="message" rows="10" :placeholder="$t('enter_your_message')"
                v-model="data.message" @input="delete violations.message"></textarea>
      <div class="invalid-feedback">
        <div v-for="violation in violations.message" :key="violation.code">
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
        {{ $t('send') }}
      </button>
    </div>
  </div>
</template>

<script>
import FontAwesomeIcon from '@scripts/fontawesome'
import { getViolations, Message, UnprocessableEntity } from '@scripts/services/api'

export default {
  name: 'ContactForm',
  components: {
    FontAwesomeIcon
  },
  methods: {
    submit () {
      this.disabled = true
      this.success = false
      this.violations = {}

      Message.send(this.data).then(() => {
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
