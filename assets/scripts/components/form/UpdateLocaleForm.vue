<template>

  <div v-if="success" class="alert alert-success mb-3">
    <div class="d-flex align-items-center">
      <FontAwesomeIcon class="me-3" :icon="['far', 'circle-check']" size="3x" aria-hidden="true"/>
      {{ $t('your_locale_has_been_updated') }}
    </div>
  </div>

  <form class="row g-3">
    <div class="col-12">
      <label class="form-label" for="locale">{{ $t('label.locale') }}</label>
      <LocaleSelect :class="{ 'is-invalid': violations.locale }" id="locale"
                    :can-deselect="false" v-model="data.locale" @change="delete violations.locale"/>
      <div class="invalid-feedback">
        <div v-for="violation in violations.locale" :key="violation.code">
          {{ violation.message }}
        </div>
      </div>
    </div>
    <div class="col-12 text-center">
      <button class="btn btn-outline-primary" type="button" :disabled="disabled" @click="submit">
        {{ $t('save') }}
      </button>
    </div>
  </form>
</template>

<script>
import LocaleSelect from '@scripts/components/form/fields/LocaleSelect'
import FontAwesomeIcon from '@scripts/fontawesome'
import { getViolations, UnprocessableEntity, User } from '@scripts/services/api'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'UpdateLocaleForm',
  components: {
    FontAwesomeIcon,
    LocaleSelect
  },
  computed: {
    ...mapGetters(['user'])
  },
  methods: {
    ...mapActions([
      'setLocale',
      'setUser'
    ]),
    loadUserLocale () {
      this.data.locale = this.user.locale
    },
    submit () {
      this.disabled = true
      this.success = false
      this.violations = {}

      User.updateLocale(this.user.id, this.data).then(() => {
        this.setLocale(this.data.locale)
        this.setUser({ ...this.user, locale: this.data.locale })
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
  },
  mounted () {
    this.loadUserLocale()
  }
}
</script>
