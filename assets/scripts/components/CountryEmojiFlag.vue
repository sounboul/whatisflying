<template>
  {{ countryEmojiFlag }}
</template>

<script>
import Country from '@scripts/services/country'

export default {
  name: 'CountryEmojiFlag',
  props: {
    countryCode: String
  },
  computed: {
    countryEmojiFlag () {
      return Country.getCountryEmojiFlag(this.countryCode)
    }
  }
}
</script>
