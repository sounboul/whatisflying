<template>
  <Multiselect ref="select" :multiple-label="getMultipleLabel" :options="getOptions"
               :placeholder="$t('select_a_navaid_type')"/>
</template>

<script>
import Multiselect from '@vueform/multiselect'

export default {
  name: 'NavaidTypeSelect',
  components: {
    Multiselect
  },
  methods: {
    getMultipleLabel (value) {
      return this.$tc('count.navaid_types_selected', value.length)
    },
    getOptions () {
      return new Promise(resolve => {
        const options = [
          { label: 'DME', value: 'DME' },
          { label: 'DME-ILS', value: 'DME-ILS' },
          { label: 'DME-NDB', value: 'DME-NDB' },
          { label: 'G/S', value: 'GS' },
          { label: 'IGS', value: 'IGS' },
          { label: 'ILS cat. I', value: 'ILS-I' },
          { label: 'ILS cat. II', value: 'ILS-II' },
          { label: 'ILS cat. III', value: 'ILS-III' },
          { label: 'IM', value: 'IM' },
          { label: 'LDA', value: 'LDA' },
          { label: 'LOC', value: 'LOC' },
          { label: 'MM', value: 'MM' },
          { label: 'NDB', value: 'NDB' },
          { label: 'OM', value: 'OM' },
          { label: 'SDF', value: 'SDF' },
          { label: 'TACAN', value: 'TACAN' },
          { label: 'VOR', value: 'VOR' },
          { label: 'VOR-DME', value: 'VOR-DME' },
          { label: 'VORTAC', value: 'VORTAC' }
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
