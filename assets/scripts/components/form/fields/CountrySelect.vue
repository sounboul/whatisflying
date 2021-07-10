<template>
  <Multiselect :multiple-label="getMultipleLabel" :no-results-text="$t('no_results_found')" :options="getOptions"
               :placeholder="$t('select_a_country')" :searchable="true"/>
</template>

<script>
import Country from '@scripts/services/country'
import Multiselect from '@vueform/multiselect'

export default {
  name: 'CountrySelect',
  components: {
    Multiselect
  },
  methods: {
    getMultipleLabel (value) {
      return this.$tc('count.countries_selected', value.length)
    },
    getOptions () {
      return new Promise(resolve => {
        const options = []
        const countryCodes = Country.getCountryCodes()
        countryCodes.forEach(countryCode => {
          const countryName = Country.getCountryName(countryCode)
          const countryNativeName = Country.getCountryNativeName(countryCode)
          const countryEmojiFlag = Country.getCountryEmojiFlag(countryCode)

          let label = `${countryEmojiFlag} ${countryName}`
          if (countryNativeName !== countryName) {
            label += ` (${countryNativeName})`
          }

          options.push({
            label,
            value: countryCode
          })
        })

        resolve(options)
      })
    }
  }
}
</script>
