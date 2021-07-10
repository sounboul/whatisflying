<template>
  <div class="card card-body">
    <h3>{{ $t('radio_frequencies') }}</h3>

    <div v-if="!airportFrequenciesLoaded || airportFrequencies['hydra:totalItems']" class="table-responsive">
      <table class="table mb-0">
        <thead>
          <tr>
            <th scope="col" class="col-1">
              <ColumnHeader v-model="order.type">
                {{ $t('type') }}
              </ColumnHeader>
            </th>
            <th scope="col" class="col-1">
              <ColumnHeader v-model="order.frequency">
                {{ $t('frequency') }}
              </ColumnHeader>
            </th>
            <th scope="col" class="col-2">
              <ColumnHeader v-model="order.description">
                {{ $t('description') }}
              </ColumnHeader>
            </th>
          </tr>
        </thead>
        <tbody>

          <template v-if="airportFrequenciesLoaded">
            <tr v-for="airportFrequency in airportFrequencies['hydra:member']" :key="airportFrequency.id">
              <td>{{ airportFrequency.type }}</td>
              <td>{{ $n($m.unit(airportFrequency.frequency, 'kHz').toNumber('MHz')) }}&nbsp;MHz</td>
              <td>{{ airportFrequency.description }}</td>
            </tr>
          </template>

          <template v-else>
            <tr v-for="index in $m.range(0, 5).toArray()" :key="index">
              <td>
                <ContentLoader width="100" height="15"/>
              </td>
              <td>
                <ContentLoader width="100" height="15"/>
              </td>
              <td>
                <ContentLoader width="200" height="15"/>
              </td>
            </tr>
          </template>

        </tbody>
      </table>
    </div>

    <div v-else>
      <NoDataAvailable/>
    </div>

  </div>
</template>

<script>
import ColumnHeader from '@scripts/components/ColumnHeader'
import ContentLoader from '@scripts/components/ContentLoader'
import NoDataAvailable from '@scripts/components/NoDataAvailable'
import { Airport } from '@scripts/services/api'
import { CancelToken } from 'axios'

export default {
  name: 'AirportRadioFrequencies',
  components: {
    ColumnHeader,
    ContentLoader,
    NoDataAvailable
  },
  props: {
    airport: String
  },
  methods: {
    loadAirportFrequencies () {
      this.cancelToken?.cancel('Concurrent request')
      this.cancelToken = CancelToken.source()
      this.airportFrequenciesLoaded = false

      Airport.getAirportFrequencies(this.airport, {
        cancelToken: this.cancelToken.token,
        params: {
          order: this.order,
          properties: ['id', 'description', 'frequency', 'type']
        }
      }).then(airportFrequencies => {
        this.airportFrequencies = airportFrequencies
        this.airportFrequenciesLoaded = true
      })
    }
  },
  watch: {
    order: {
      deep: true,
      handler () {
        this.loadAirportFrequencies()
      }
    }
  },
  data () {
    return {
      airportFrequencies: null,
      airportFrequenciesLoaded: false,
      cancelToken: null,
      order: {}
    }
  },
  mounted () {
    this.loadAirportFrequencies()
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
