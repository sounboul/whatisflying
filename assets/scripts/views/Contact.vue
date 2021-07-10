<template>
  <CenteredLayout max-width="500px">

    <template #title>{{ $t('contact') }}</template>

    <template #content>
      <div class="card card-body">
        <ContactForm/>
      </div>
    </template>

  </CenteredLayout>
</template>

<script>
import ContactForm from '@scripts/components/form/ContactForm'
import CenteredLayout from '@scripts/layouts/CenteredLayout'
import { mapActions } from 'vuex'

export default {
  name: 'Contact',
  components: {
    CenteredLayout,
    ContactForm
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
        this.setMetaTitle(this.$t('contact'))
        this.setPageTitle(this.$t('contact'))
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
