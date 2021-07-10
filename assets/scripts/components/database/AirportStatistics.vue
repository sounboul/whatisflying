<template>
  <div class="card card-body">
    <h3 class="card-title">{{ $t('statistics') }}</h3>

    <template v-if="!airportDatasetsLoaded || airportDatasets['hydra:totalItems']">
      <ListHeader :items="airportDatasets" :items-loaded="airportDatasetsLoaded"/>
      <hr>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead>
            <tr>
              <th scope="col" class="col-1">
                <ColumnHeader v-model="order.year">
                  {{ $t('year') }}
                </ColumnHeader>
              </th>
              <th scope="col" class="col-2">
                <ColumnHeader v-model="order.domesticDestinations">
                  {{ $t('domestic_destinations') }}
                </ColumnHeader>
              </th>
              <th scope="col" class="col-2">
                <ColumnHeader v-model="order.domesticDepartures">
                  {{ $t('domestic_flight_departures') }}
                </ColumnHeader>
              </th>
              <th scope="col" class="col-2">
                <ColumnHeader v-model="order.internationalDestinations">
                  {{ $t('international_destinations') }}
                </ColumnHeader>
              </th>
              <th scope="col" class="col-2">
                <ColumnHeader v-model="order.internationalDepartures">
                  {{ $t('international_flight_departures') }}
                </ColumnHeader>
              </th>
            </tr>
          </thead>
          <tbody>

            <template v-if="airportDatasetsLoaded">
              <tr v-for="airportDataset in airportDatasets['hydra:member']" :key="airportDataset.id">
                <td>{{ airportDataset.year }}</td>
                <td class="text-center">{{ $n(airportDataset.domesticDestinations) }}</td>
                <td class="text-center">{{ $n(airportDataset.domesticDepartures) }}</td>
                <td class="text-center">{{ $n(airportDataset.internationalDestinations) }}</td>
                <td class="text-center">{{ $n(airportDataset.internationalDepartures) }}</td>
              </tr>
            </template>

            <template v-else>
              <tr v-for="index in $m.range(0, 10).toArray()" :key="index">
                <td>
                  <ContentLoader width="50" height="15"/>
                </td>
                <td>
                  <ContentLoader width="100" height="15"/>
                </td>
                <td>
                  <ContentLoader width="100" height="15"/>
                </td>
                <td>
                  <ContentLoader width="100" height="15"/>
                </td>
                <td>
                  <ContentLoader width="100" height="15"/>
                </td>
              </tr>
            </template>

          </tbody>
        </table>
      </div>
      <Pagination class="mt-3" :items="airportDatasets" :itemsLoaded="airportDatasetsLoaded" v-model="page"/>
    </template>

    <template v-else>
      <NoDataAvailable/>
    </template>

  </div>
</template>

<script>
import ColumnHeader from '@scripts/components/ColumnHeader'
import ContentLoader from '@scripts/components/ContentLoader'
import ListHeader from '@scripts/components/ListHeader'
import NoDataAvailable from '@scripts/components/NoDataAvailable'
import Pagination from '@scripts/components/Pagination'
import { Airport } from '@scripts/services/api'
import { CancelToken } from 'axios'

export default {
  name: 'AirportStatistics',
  components: {
    ColumnHeader,
    ContentLoader,
    ListHeader,
    NoDataAvailable,
    Pagination
  },
  props: {
    airport: String
  },
  methods: {
    loadAirportDatasets () {
      this.cancelToken?.cancel('Concurrent request')
      this.cancelToken = CancelToken.source()
      this.airportDatasetsLoaded = false

      Airport.getAirportDatasets(this.airport, {
        cancelToken: this.cancelToken.token,
        params: {
          itemsPerPage: 10,
          order: this.order,
          page: this.page,
          properties: [
            'id',
            'domesticDepartures',
            'domesticDestinations',
            'internationalDepartures',
            'internationalDestinations',
            'year'
          ]
        }
      }).then(airportDatasets => {
        this.airportDatasets = airportDatasets
        this.airportDatasetsLoaded = true
      })
    }
  },
  watch: {
    order: {
      deep: true,
      handler () {
        this.loadAirportDatasets()
      }
    },
    page () {
      this.loadAirportDatasets()
    }
  },
  data () {
    return {
      airportDatasets: null,
      airportDatasetsLoaded: false,
      cancelToken: null,
      order: {},
      page: 1
    }
  },
  mounted () {
    this.loadAirportDatasets()
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
