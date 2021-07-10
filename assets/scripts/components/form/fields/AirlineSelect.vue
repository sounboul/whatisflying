<template>
  <Multiselect :multiple-label="getMultipleLabel" :no-results-text="$t('no_results_found')" :options="getOptions"
               :placeholder="$t('select_an_airline')" :searchable="true"/>
</template>

<script>
import { Airline } from '@scripts/services/api'
import Multiselect from '@vueform/multiselect'
import { CancelToken } from 'axios'

export default {
  name: 'AirlineSelect',
  components: {
    Multiselect
  },
  methods: {
    getMultipleLabel (value) {
      return this.$tc('count.airlines_selected', value.length)
    },
    getOptions () {
      return new Promise((resolve, reject) => {
        this.cancelToken?.cancel('Concurrent request')
        this.cancelToken = CancelToken.source()

        Airline.getAirlines({
          cancelToken: this.cancelToken.token,
          params: {
            pagination: false,
            properties: ['icaoCode', 'name']
          }
        }).then(airlines => {
          const options = []
          airlines['hydra:member'].forEach(airline => {
            const { icaoCode, name } = airline
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
