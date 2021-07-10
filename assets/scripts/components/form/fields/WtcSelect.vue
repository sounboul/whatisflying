<template>
  <Multiselect ref="select" :multiple-label="getMultipleLabel" :options="getOptions"
               :placeholder="$t('select_a_wake_turbulence_category')"/>
</template>

<script>
import Multiselect from '@vueform/multiselect'

export default {
  name: 'WtcSelect',
  components: {
    Multiselect
  },
  methods: {
    getMultipleLabel (value) {
      return this.$tc('count.wtc_selected', value.length)
    },
    getOptions () {
      return new Promise(resolve => {
        const options = [
          { label: this.$t('light__m'), value: 'L' },
          { label: this.$t('medium__m'), value: 'M' },
          { label: this.$t('heavy__m'), value: 'H' }
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
