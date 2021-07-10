<template>
  <CenteredLayout max-width="800px">

    <template #title>{{ $t('legal_notice') }}</template>

    <template #content>
      <div class="card card-body">
        <h2>{{ $t('hosting_provider') }}</h2>
        <address>
          <strong>OVH SAS</strong><br>
          2 rue Kellermann<br>
          59100 Roubaix<br>
          France
        </address>
        <i18n-t tag="p" keypath="static.legal_notice[0]">
          <template #link>
            <a href="tel:+33972101007">
              {{ $t('static.legal_notice[1]') }}
            </a>
          </template>
        </i18n-t>
        <h2>{{ $t('personal_data') }}</h2>
        <i18n-t tag="p" keypath="static.legal_notice[2]">
          <template #link>
            <RouterLink :to="{ name: 'privacy_policy' }">
              {{ $t('privacy_policy') }}
            </RouterLink>
          </template>
        </i18n-t>
        <h2>{{ $t('cookies') }}</h2>
        <i18n-t tag="p" keypath="static.legal_notice[3]">
          <template #link>
            <RouterLink :to="{ name: 'cookie_policy' }">
              {{ $t('cookie_policy') }}
            </RouterLink>
          </template>
        </i18n-t>
        <h2>{{ $t('licenses') }}</h2>
        <i18n-t tag="p" keypath="static.legal_notice[4]">
          <template #link>
            <a rel="noopener noreferrer" target="_blank"
               href="https://spdx.org/licenses/MIT.html">MIT</a>
          </template>
        </i18n-t>
        <i18n-t tag="p" keypath="static.legal_notice[5]">
          <template #link>
            <a rel="noopener noreferrer" target="_blank"
               href="https://spdx.org/licenses/ODbL-1.0.html">ODC Open Database License v1.0</a>
          </template>
        </i18n-t>
        <i18n-t tag="p" keypath="static.legal_notice[6]">
          <template #link>
            <a rel="noopener noreferrer" target="_blank"
               href="https://spdx.org/licenses/CC-BY-SA-4.0.html">Creative Commons CC-BY-SA-4.0</a>
          </template>
        </i18n-t>
        <h2>{{ $t('limited_liability') }}</h2>
        <p>{{ $t('static.legal_notice[7]') }}</p>
        <p class="text-danger">
          <strong>{{ $t('static.legal_notice[8]') }}</strong>
        </p>
      </div>
    </template>

  </CenteredLayout>
</template>

<script>
import CenteredLayout from '@scripts/layouts/CenteredLayout'
import { mapActions } from 'vuex'

export default {
  name: 'LegalNotice',
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
        this.setMetaTitle(this.$t('legal_notice'))
        this.setPageTitle(this.$t('legal_notice'))
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
