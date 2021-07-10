<template>
  <CenteredLayout max-width="500px">

    <template #title>{{ $t('not_found') }}</template>

    <template #content>
      <div class="card card-body">
        {{ $t('the_requested_page_was_not_found') }}
      </div>
    </template>

  </CenteredLayout>
</template>

<script>
import CenteredLayout from '@scripts/layouts/CenteredLayout'
import { mapActions } from 'vuex'

export default {
  name: 'NotFound',
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
        this.setPageTitle(this.$t('not_found'))
      }
    }
  },
  mounted () {
    this.setMetaDescription(null)
    this.setMetaRobots('noindex,follow')
    this.setMetaTitle(null)
    this.setMetaUrl(null)
  }
}
</script>
