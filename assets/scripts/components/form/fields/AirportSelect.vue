<template>
  <Multiselect :multiple-label="getMultipleLabel" :no-results-text="$t('no_results_found')" :options="getOptions"
               :placeholder="$t('select_an_airport')" :searchable="true"/>
</template>

<script>
import { Airport } from '@scripts/services/api'
import Multiselect from '@vueform/multiselect'
import { CancelToken } from 'axios'

export default {
  name: 'AirportSelect',
  components: {
    Multiselect
  },
  methods: {
    getMultipleLabel (value) {
      return this.$tc('count.airports_selected', value.length)
    },
    getOptions () {
      return new Promise((resolve, reject) => {
        this.cancelToken?.cancel('Concurrent request')
        this.cancelToken = CancelToken.source()

        Airport.getAirports({
          cancelToken: this.cancelToken.token,
          params: {
            pagination: false,
            properties: ['icaoCode', 'name']
          }
        }).then(airports => {
          const options = []
          airports['hydra:member'].forEach(airport => {
            const { icaoCode, name } = airport
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
