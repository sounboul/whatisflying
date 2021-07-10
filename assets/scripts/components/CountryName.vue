<template>
  {{ countryName }}

  <template v-if="countryName !== countryNativeName">
    ({{ countryNativeName }})
  </template>

</template>

<script>
import Country from '@scripts/services/country'

export default {
  name: 'CountryName',
  props: {
    countryCode: String
  },
  computed: {
    countryName () {
      return Country.getCountryName(this.countryCode)
    },
    countryNativeName () {
      return Country.getCountryNativeName(this.countryCode)
    }
  }
}
</script>
