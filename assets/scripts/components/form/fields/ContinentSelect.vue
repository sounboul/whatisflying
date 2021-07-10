<template>
  <Multiselect :multiple-label="getMultipleLabel" :options="getOptions" :placeholder="$t('select_a_continent')"/>
</template>

<script>
import Country from '@scripts/services/country'
import Multiselect from '@vueform/multiselect'

export default {
  name: 'ContinentSelect',
  components: {
    Multiselect
  },
  methods: {
    getMultipleLabel (value) {
      return this.$tc('count.continents_selected', value.length)
    },
    getOptions () {
      return new Promise(resolve => {
        const options = []
        const continentCodes = Country.getContinentCodes()
        continentCodes.forEach(continentCode => {
          const continentName = Country.getContinentName(continentCode)
          options.push({
            label: continentName,
            value: continentCode
          })
        })

        resolve(options)
      })
    }
  }
}
</script>
