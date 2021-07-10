<template>
  {{ continentName }}
</template>

<script>
import Country from '@scripts/services/country'

export default {
  name: 'ContinentName',
  props: {
    continentCode: String
  },
  computed: {
    continentName () {
      return Country.getContinentName(this.continentCode)
    }
  }
}
</script>
