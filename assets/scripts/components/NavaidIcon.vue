<template>
  <img :src="src" alt="">
</template>

<script>
export default {
  name: 'NavaidIcon',
  props: {
    navaidType: String
  },
  computed: {
    src () {
      return require(`@images/navaid/${this.navaidType}.svg`)
    }
  }
}
</script>
