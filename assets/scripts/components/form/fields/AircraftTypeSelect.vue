<template>
  <Multiselect :multiple-label="getMultipleLabel" :no-results-text="$t('no_results_found')" :options="getOptions"
               :placeholder="$t('select_an_aircraft_type')" :searchable="true"/>
</template>

<script>
import { AircraftType } from '@scripts/services/api'
import Multiselect from '@vueform/multiselect'
import { CancelToken } from 'axios'

export default {
  name: 'AircraftTypeSelect',
  components: {
    Multiselect
  },
  methods: {
    getMultipleLabel (value) {
      return this.$tc('count.aircraft_types_selected', value.length)
    },
    getOptions () {
      return new Promise((resolve, reject) => {
        this.cancelToken?.cancel('Concurrent request')
        this.cancelToken = CancelToken.source()

        AircraftType.getAircraftTypes({
          cancelToken: this.cancelToken.token,
          params: {
            pagination: false,
            properties: ['icaoCode', 'manufacturer', 'name']
          }
        }).then(aircraftTypes => {
          const options = []
          aircraftTypes['hydra:member'].forEach(aircraftType => {
            const { icaoCode, manufacturer, name } = aircraftType
            options.push({
              label: `${icaoCode} - ${manufacturer} ${name}`,
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
