<template>
  <CenteredLayout max-width="500px">

    <template #title>{{ $t('activate_account') }}</template>

    <template #content>
      <div class="card card-body">

        <div v-if="error" class="alert alert-danger mb-3">
          <div class="d-flex align-items-center">
            <FontAwesomeIcon class="me-3" :icon="['far', 'circle-exclamation']" size="3x" aria-hidden="true"/>
            {{ error }}
          </div>
        </div>

        <template v-if="success">
          <div class="alert alert-success mb-3">
            <div class="d-flex align-items-center">
              <FontAwesomeIcon class="me-3" :icon="['far', 'circle-check']" size="3x" aria-hidden="true"/>
              {{ $t('your_account_has_been_activated') }}
            </div>
          </div>
        </template>

      </div>
    </template>

  </CenteredLayout>
</template>

<script>
import CenteredLayout from '@scripts/layouts/CenteredLayout'
import { Unauthorized, User } from '@scripts/services/api'
import store from '@scripts/store'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'ActivateAccount',
  components: {
    CenteredLayout
  },
  props: {
    id: String,
    token: String
  },
  computed: {
    ...mapGetters(['user'])
  },
  methods: {
    ...mapActions([
      'setMetaDescription',
      'setMetaRobots',
      'setMetaTitle',
      'setMetaUrl',
      'setPageTitle'
    ]),
    activateAccount () {
      User.activateAccount(this.$props.id, { token: this.$props.token }).then(() => {
        this.success = true
      }).catch(error => {
        if (error instanceof Unauthorized) {
          this.error = this.$t('account_activation_link_is_invalid_or_has_expired')
          return
        }

        throw error
      })
    }
  },
  watch: {
    '$i18n.locale': {
      immediate: true,
      handler () {
        this.setPageTitle(this.$t('activate_account'))
      }
    },
    user (user) {
      if (user) {
        this.$router.replace({ name: 'live_tracker' })
      }
    }
  },
  data () {
    return {
      error: null,
      success: false
    }
  },
  mounted () {
    this.setMetaDescription(null)
    this.setMetaRobots('noindex,follow')
    this.setMetaTitle(null)
    this.setMetaUrl(null)
    this.activateAccount()
  },
  beforeRouteEnter (to, from, next) {
    if (store.getters.user) {
      next({ name: 'live_tracker' })
      return
    }

    next()
  }
}
</script>
