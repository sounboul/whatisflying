<template>
  <CenteredLayout max-width="500px">

    <template #title>{{ $t('sign_up') }}</template>

    <template #content>
      <div class="card card-body">
        <SignUpForm/>
      </div>
    </template>

  </CenteredLayout>
</template>

<script>
import SignUpForm from '@scripts/components/form/SignUpForm'
import CenteredLayout from '@scripts/layouts/CenteredLayout'
import store from '@scripts/store'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'SignUp',
  components: {
    CenteredLayout,
    SignUpForm
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
        this.setMetaTitle(this.$t('sign_up'))
        this.setPageTitle(this.$t('sign_up'))
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
    this.setMetaRobots('index,follow,noarchive')
    this.setMetaUrl(this.$route.path)
  }
}
</script>
