<template>
  <div class="footer">
    <div class="container">
      <div class="row g-3">
        <div class="col-12 col-lg-6">
          <h5 class="text-reset">{{ $t('footer.copyright') }}</h5>
          <p class="text-muted">
            <i18n-t keypath="footer.source_code_license">
              <template #link>
                <a class="footer-link" rel="license noopener noreferrer" target="_blank"
                   href="https://spdx.org/licenses/MIT.html">
                  <u>MIT</u>
                </a>
              </template>
            </i18n-t>
            <br>
            <i18n-t keypath="footer.data_license">
              <template #link>
                <a class="footer-link" rel="license noopener noreferrer" target="_blank"
                   href="https://spdx.org/licenses/ODbL-1.0.html">
                  <u>ODC Open Database License v1.0</u>
                </a>
              </template>
            </i18n-t>
          </p>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
          <h5 class="text-reset">{{ $t('information') }}</h5>
          <ul class="footer-nav">
            <li>
              <RouterLink class="footer-link" active-class="active" :to="{ name: 'legal_notice' }">
                {{ $t('legal_notice') }}
              </RouterLink>
            </li>
            <li>
              <RouterLink class="footer-link" active-class="active" :to="{ name: 'privacy_policy' }">
                {{ $t('privacy_policy') }}
              </RouterLink>
            </li>
            <li>
              <RouterLink class="footer-link" active-class="active" :to="{ name: 'cookie_policy' }">
                {{ $t('cookie_policy') }}
              </RouterLink>
            </li>
          </ul>
        </div>
        <div class="col-md-6 col-lg-3">
          <h5 class="text-reset">{{ $t('contact_us') }}</h5>
          <ul class="footer-nav">
            <li>
              <RouterLink class="footer-link" active-class="active" :to="{ name: 'contact' }">
                {{ $t('contact_form') }}
              </RouterLink>
            </li>
          </ul>
          <h5 class="text-reset">{{ $t('downloads') }}</h5>
          <ul class="footer-nav">
            <li>
              <a class="footer-link" href="https://github.com/jbroutier/whatisflying-db">
                <FontAwesomeIcon class="me-2" :icon="['fab', 'github']" aria-hidden="true"/>
                {{ $t('database') }}
              </a>
            </li>
            <li>
              <a class="footer-link" href="https://github.com/jbroutier/whatisflying">
                <FontAwesomeIcon class="me-2" :icon="['fab', 'github']" aria-hidden="true"/>
                {{ $t('source_code') }}
              </a>
            </li>
          </ul>
        </div>
        <div class="col-12">
          <p class="text-muted small">
            {{ $t('version', { version: appVersion }) }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import FontAwesomeIcon from '@scripts/fontawesome'

export default {
  name: 'Footer',
  components: {
    FontAwesomeIcon
  },
  computed: {
    appVersion () {
      return process.env.npm_package_version
    }
  }
}
</script>
