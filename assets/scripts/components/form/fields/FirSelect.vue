<template>
  <Multiselect :multiple-label="getMultipleLabel" :no-results-text="$t('no_results_found')" :options="getOptions"
               :placeholder="$t('select_a_fir')" :searchable="true"/>
</template>

<script>
import { Fir } from '@scripts/services/api'
import Multiselect from '@vueform/multiselect'
import { CancelToken } from 'axios'

export default {
  name: 'FirSelect',
  components: {
    Multiselect
  },
  methods: {
    getMultipleLabel (value) {
      return this.$tc('count.firs_selected', value.length)
    },
    getOptions () {
      return new Promise((resolve, reject) => {
        this.cancelToken?.cancel('Concurrent request')
        this.cancelToken = CancelToken.source()

        Fir.getFirs({
          cancelToken: this.cancelToken.token,
          params: {
            pagination: false,
            properties: ['icaoCode', 'name']
          }
        }).then(firs => {
          const options = []
          firs['hydra:member'].forEach(fir => {
            const { icaoCode, name } = fir
            options.push({
              label: `${icaoCode} - ${name}`,
              value: icaoCode
            })
          })

          resolve(options)
        }).catch(error => reject(error))
      })
    }
  },
  data () {
    return {
      cancelToken: null
    }
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
