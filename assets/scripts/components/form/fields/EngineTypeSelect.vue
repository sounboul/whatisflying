<template>
  <Multiselect ref="select" :multiple-label="getMultipleLabel" :options="getOptions"
               :placeholder="$t('select_an_engine_type')"/>
</template>

<script>
import Multiselect from '@vueform/multiselect'

export default {
  name: 'EngineTypeSelect',
  components: {
    Multiselect
  },
  methods: {
    getMultipleLabel (value) {
      return this.$tc('count.engine_types_selected', value.length)
    },
    getOptions () {
      return new Promise(resolve => {
        const options = [
          { label: this.$t('electric'), value: 'E' },
          { label: this.$t('turbojet'), value: 'J' },
          { label: this.$t('piston'), value: 'P' },
          { label: this.$t('turboprop_turboshaft'), value: 'T' }
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
