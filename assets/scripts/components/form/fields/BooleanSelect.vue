<template>
  <Multiselect ref="select" :options="getOptions" :placeholder="$t('select_a_value')"/>
</template>

<script>
import Multiselect from '@vueform/multiselect'

export default {
  name: 'BooleanSelect',
  components: {
    Multiselect
  },
  methods: {
    getOptions () {
      return new Promise(resolve => {
        const options = [
          { label: this.$t('yes'), value: 1 },
          { label: this.$t('no'), value: 0 }
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
