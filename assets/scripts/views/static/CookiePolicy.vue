<template>
  <CenteredLayout max-width="800px">

    <template #title>{{ $t('cookie_policy') }}</template>

    <template #content>
      <div class="card card-body">
        <h2>{{ $t('cookies') }}</h2>
        <h4>{{ $t('what_are_cookies') }}</h4>
        <p>{{ $t('static.cookie_policy[0]') }}</p>
        <h4>{{ $t('how_do_we_use_cookies') }}</h4>
        <p>{{ $t('static.cookie_policy[1]') }}</p>
        <h2>{{ $t('local_storage') }}</h2>
        <h4>{{ $t('what_is_local_storage') }}</h4>
        <p>{{ $t('static.cookie_policy[2]') }}</p>
        <ul>
          <li>{{ $t('static.cookie_policy[3]') }}</li>
          <li>{{ $t('static.cookie_policy[4]') }}</li>
          <li>{{ $t('static.cookie_policy[5]') }}</li>
        </ul>
        <h4>{{ $t('how_do_we_use_local_storage') }}</h4>
        <ul>
          <li>{{ $t('static.cookie_policy[6]') }}</li>
          <li>{{ $t('static.cookie_policy[7]') }}</li>
          <li>{{ $t('static.cookie_policy[8]') }}</li>
        </ul>
      </div>
    </template>

  </CenteredLayout>
</template>

<script>
import CenteredLayout from '@scripts/layouts/CenteredLayout'
import { mapActions } from 'vuex'

export default {
  name: 'CookiePolicy',
  components: {
    CenteredLayout
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
        this.setMetaTitle(this.$t('cookie_policy'))
        this.setPageTitle(this.$t('cookie_policy'))
      }
    }
  },
  mounted () {
    this.setMetaDescription(null)
    this.setMetaRobots('index,follow,noarchive')
    this.setMetaUrl(this.$route.path)
  }
}
</script>
