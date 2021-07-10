<template>
  <Multiselect ref="select" :options="getOptions" :placeholder="$t('select_a_locale')"/>
</template>

<script>
import Multiselect from '@vueform/multiselect'

export default {
  name: 'LocaleSelect',
  components: {
    Multiselect
  },
  methods: {
    getOptions () {
      return new Promise(resolve => {
        const options = [
          { label: `🇬🇧 ${this.$t('english')}`, value: 'en' },
          { label: `🇫🇷 ${this.$t('french')}`, value: 'fr' }
        ]

        resolve(options)
      })
    }
  },
  watch: {
    '$i18n.locale' () {
      this.$refs.select.refreshOptions()
    }
  }
}
</script>
