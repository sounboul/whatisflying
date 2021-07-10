<template>
  <CenteredLayout max-width="800px">

    <template #title>{{ $t('privacy_policy') }}</template>

    <template #content>
      <div class="card card-body">
        <h2>{{ $t('personal_data') }}</h2>
        <p>{{ $t('static.privacy_policy[0]') }}</p>
        <h3>{{ $t('means_of_data_collection') }}</h3>
        <p>{{ $t('static.privacy_policy[1]') }}</p>
        <h4>{{ $t('automatically_collected_data') }}</h4>
        <p>{{ $t('static.privacy_policy[2]') }}</p>
        <h4>{{ $t('data_you_send_us') }}</h4>
        <p>{{ $t('static.privacy_policy[3]') }}</p>
        <h3>{{ $t('collected_data') }}</h3>
        <h4>{{ $t('exclusion_of_sensitive_data') }}</h4>
        <p>{{ $t('static.privacy_policy[4]') }}</p>
        <h3>{{ $t('personal_data_categories_collected') }}</h3>
        <p>{{ $t('static.privacy_policy[5]') }}</p>
        <ul>
          <li>{{ $t('static.privacy_policy[6]') }}</li>
          <li>{{ $t('static.privacy_policy[7]') }}</li>
          <li>{{ $t('static.privacy_policy[8]') }}</li>
          <li>{{ $t('static.privacy_policy[9]') }}</li>
        </ul>
        <h3>{{ $t('retention_period') }}</h3>
        <p>{{ $t('static.privacy_policy[10]') }}</p>
        <ul>
          <li>{{ $t('static.privacy_policy[11]') }}</li>
          <li>{{ $t('static.privacy_policy[12]') }}</li>
          <li>{{ $t('static.privacy_policy[13]') }}</li>
          <li>{{ $t('static.privacy_policy[14]') }}</li>
        </ul>
        <h3>{{ $t('legal_basis_for_the_processing') }}</h3>
        <p>{{ $t('static.privacy_policy[15]') }}</p>
        <ul>
          <li>{{ $t('static.privacy_policy[16]') }}</li>
          <li>{{ $t('static.privacy_policy[17]') }}</li>
          <li>{{ $t('static.privacy_policy[18]') }}</li>
          <li>{{ $t('static.privacy_policy[19]') }}</li>
        </ul>
        <h3>{{ $t('data_recipients') }}</h3>
        <p>{{ $t('static.privacy_policy[20]') }}</p>
        <h3>{{ $t('data_transfer_outside_the_european_union') }}</h3>
        <p>{{ $t('static.privacy_policy[21]') }}</p>
        <h4>{{ $t('data_protection') }}</h4>
        <p>{{ $t('static.privacy_policy[22]') }}</p>
        <h4>{{ $t('service_providers') }}</h4>
        <ul>
          <i18n-t tag="li" keypath="static.privacy_policy[23]">
            <template #link>
              <a rel="noopener noreferrer" target="_blank"
                 href="https://sentry.io/"><strong>Sentry</strong></a>
            </template>
          </i18n-t>
        </ul>
        <h3>{{ $t('data_storage') }}</h3>
        <p>{{ $t('static.privacy_policy[24]') }}</p>
        <h3>{{ $t('data_security') }}</h3>
        <p>{{ $t('static.privacy_policy[25]') }}</p>
        <h3>{{ $t('rights_of_data_subjects') }}</h3>
        <p>{{ $t('static.privacy_policy[26]') }}</p>
        <ul>
          <i18n-t tag="li" keypath="static.privacy_policy[27]">
            <template #link>
              <RouterLink :to="{ name: 'contact' }">{{ $t('contact_form') }}</RouterLink>
            </template>
          </i18n-t>
          <i18n-t tag="li" keypath="static.privacy_policy[28]">
            <template #link>
              <a href="mailto:contact@whatisflying.com">contact@whatisflying.com</a>
            </template>
          </i18n-t>
        </ul>
        <p>{{ $t('static.privacy_policy[29]') }}</p>
        <h4>{{ $t('right_to_access') }}</h4>
        <p>{{ $t('static.privacy_policy[30]') }}</p>
        <ul>
          <li>{{ $t('static.privacy_policy[31]') }}</li>
          <li>{{ $t('static.privacy_policy[32]') }}</li>
          <li>{{ $t('static.privacy_policy[33]') }}</li>
          <li>{{ $t('static.privacy_policy[34]') }}</li>
          <li>{{ $t('static.privacy_policy[35]') }}</li>
          <li>{{ $t('static.privacy_policy[36]') }}</li>
        </ul>
        <h4>{{ $t('right_to_correct') }}</h4>
        <p>{{ $t('static.privacy_policy[37]') }}</p>
        <p>{{ $t('static.privacy_policy[38]') }}</p>
        <ul>
          <i18n-t tag="li" keypath="static.privacy_policy[39]">
            <template #link>
              <RouterLink :to="{ name: 'user_security' }">{{ $t('update_password') }}</RouterLink>
            </template>
          </i18n-t>
        </ul>
        <h4>{{ $t('right_to_deletion') }}</h4>
        <p>{{ $t('static.privacy_policy[40]') }}</p>
        <ul>
          <li>{{ $t('static.privacy_policy[41]') }}</li>
          <li>{{ $t('static.privacy_policy[42]') }}</li>
          <li>{{ $t('static.privacy_policy[43]') }}</li>
          <li>{{ $t('static.privacy_policy[44]') }}</li>
          <li>{{ $t('static.privacy_policy[45]') }}</li>
        </ul>
        <p>{{ $t('static.privacy_policy[46]') }}</p>
        <ul>
          <i18n-t tag="li" keypath="static.privacy_policy[47]">
            <template #link>
              <RouterLink :to="{ name: 'user_privacy' }">{{ $t('delete_account') }}</RouterLink>
            </template>
          </i18n-t>
        </ul>
        <h4>{{ $t('right_to_limitation_of_processing') }}</h4>
        <p>{{ $t('static.privacy_policy[48]') }}</p>
        <ul>
          <li>{{ $t('static.privacy_policy[49]') }}</li>
          <li>{{ $t('static.privacy_policy[50]') }}</li>
          <li>{{ $t('static.privacy_policy[51]') }}</li>
          <li>{{ $t('static.privacy_policy[52]') }}</li>
        </ul>
        <h4>{{ $t('right_to_portability') }}</h4>
        <p>{{ $t('static.privacy_policy[53]') }}</p>
        <ul>
          <li>{{ $t('static.privacy_policy[54]') }}</li>
          <li>{{ $t('static.privacy_policy[55]') }}</li>
        </ul>
        <p>{{ $t('static.privacy_policy[56]') }}</p>
        <ul>
          <i18n-t tag="li" keypath="static.privacy_policy[57]">
            <template #link>
              <RouterLink :to="{ name: 'user_privacy' }">{{ $t('export_personal_data') }}</RouterLink>
            </template>
          </i18n-t>
        </ul>
        <h2>{{ $t('cookies') }}</h2>
        <i18n-t tag="p" keypath="static.privacy_policy[58]">
          <template #link>
            <RouterLink :to="{ name: 'cookie_policy' }">{{ $t('cookie_policy') }}</RouterLink>
          </template>
        </i18n-t>
      </div>
    </template>

  </CenteredLayout>
</template>

<script>
import CenteredLayout from '@scripts/layouts/CenteredLayout'
import { mapActions } from 'vuex'

export default {
  name: 'PrivacyPolicy',
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
        this.setMetaTitle(this.$t('privacy_policy'))
        this.setPageTitle(this.$t('privacy_policy'))
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
