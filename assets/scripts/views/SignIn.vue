<template>
  <CenteredLayout max-width="500px">

    <template #title>{{ $t('sign_in') }}</template>

    <template #content>
      <div class="card card-body">
        <SignInForm/>
      </div>
    </template>

  </CenteredLayout>
</template>

<script>
import SignInForm from '@scripts/components/form/SignInForm'
import CenteredLayout from '@scripts/layouts/CenteredLayout'
import store from '@scripts/store'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'SignUp',
  components: {
    CenteredLayout,
    SignInForm
  },
  computed: {
    ...mapGetters(['user']),
    target () {
      return this.$route.query?.target || 'live_tracker'
    }
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
        this.setMetaTitle(this.$t('sign_in'))
        this.setPageTitle(this.$t('sign_in'))
      }
    },
    user (user) {
      if (user) {
        this.$router.replace({ name: this.target })
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
    this.setMetaRobots('index,follow,noarchive')
    this.setMetaUrl(this.$route.path)
  }
}
</script>
