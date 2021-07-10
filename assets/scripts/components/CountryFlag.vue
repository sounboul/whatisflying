<template>
  <img :src="src" alt="">
</template>

<script>
export default {
  name: 'CountryFlag',
  props: {
    countryCode: String
  },
  computed: {
    src () {
      return require(`country-flag-icons/3x2/${this.countryCode}.svg`)
    }
  }
}
</script>
