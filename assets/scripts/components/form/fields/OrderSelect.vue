<template>
  <Multiselect ref="select" :options="getOptions" :placeholder="$t('select_a_sort_order')"/>
</template>

<script>
import Multiselect from '@vueform/multiselect'

export default {
  name: 'OrderSelect',
  components: {
    Multiselect
  },
  methods: {
    getOptions () {
      return new Promise(resolve => {
        const options = [
          { label: this.$t('ascending__m'), value: 'asc' },
          { label: this.$t('descending__m'), value: 'desc' }
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
