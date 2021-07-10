<template>
  <CenteredLayout max-width="500px">

    <template #title>{{ $t('forgotten_password') }}</template>

    <template #content>
      <div class="card card-body">
        <RequestPasswordResetForm/>
      </div>
    </template>

  </CenteredLayout>
</template>

<script>
import RequestPasswordResetForm from '@scripts/components/form/RequestPasswordResetForm'
import CenteredLayout from '@scripts/layouts/CenteredLayout'
import store from '@scripts/store'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'Contact',
  components: {
    CenteredLayout,
    RequestPasswordResetForm
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
    ])
  },
  watch: {
    '$i18n.locale': {
      immediate: true,
      handler () {
        this.setPageTitle(this.$t('forgotten_password'))
      }
    },
    user (user) {
      if (user) {
        this.$router.replace({ name: 'live_tracker' })
      }
    }
  },
  beforeRouteEnter (to, from, next) {
    if (store.getters.user) {
      next({ name: 'live_tracker' })
      return
    }

    next()
  },
  mounted () {
    this.setMetaDescription(null)
    this.setMetaRobots('noindex,follow')
    this.setMetaTitle(null)
    this.setMetaUrl(null)
  }
}
</script>
