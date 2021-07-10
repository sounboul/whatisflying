<template>
  <Multiselect ref="select" :multiple-label="getMultipleLabel" :options="getOptions"
               :placeholder="$t('select_an_airport_type')"/>
</template>

<script>
import Multiselect from '@vueform/multiselect'

export default {
  name: 'AirportTypeSelect',
  components: {
    Multiselect
  },
  methods: {
    getMultipleLabel (value) {
      return this.$tc('count.airport_type_selected', value.length)
    },
    getOptions () {
      return new Promise(resolve => {
        const options = [
          { label: this.$t('small_airport_air_base'), value: 'small' },
          { label: this.$t('medium_airport_air_base'), value: 'medium' },
          { label: this.$t('large_airport_air_base'), value: 'large' }
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
