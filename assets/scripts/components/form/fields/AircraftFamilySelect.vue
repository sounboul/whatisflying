<template>
  <Multiselect ref="select" :multiple-label="getMultipleLabel" :options="getOptions"
               :placeholder="$t('select_an_aircraft_family')"/>
</template>

<script>
import Multiselect from '@vueform/multiselect'

export default {
  name: 'AircraftFamilySelect',
  components: {
    Multiselect
  },
  methods: {
    getMultipleLabel (value) {
      return this.$tc('count.aircraft_families_selected', value.length)
    },
    getOptions () {
      return new Promise(resolve => {
        const options = [
          { label: this.$t('amphibious_plane'), value: 'A' },
          { label: this.$t('autogyro'), value: 'G' },
          { label: this.$t('helicopter'), value: 'H' },
          { label: this.$t('airplane'), value: 'L' },
          { label: this.$t('tiltrotor'), value: 'T' }
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
