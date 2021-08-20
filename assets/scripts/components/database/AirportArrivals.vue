<template>
  <div class="card card-body">
    <div class="d-flex justify-content-between">
      <h3 class="card-title">{{ $t('flight_arrivals') }}</h3>
      <RouterLink :to="{ name: 'database_flights', query: {
          'arrivalAirport.icaoCode': [ airport ] } }">
        <span class="visually-hidden">{{ $t('maximize') }}</span>
        <FontAwesomeIcon :icon="['far', 'arrows-maximize']" aria-hidden="true"/>
      </RouterLink>
    </div>

    <template v-if="!flightsLoaded || flights['hydra:totalItems']">
      <ListHeader :items="flights" :items-loaded="flightsLoaded"/>
      <hr>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead>
            <tr>
              <th scope="col" class="col-1">
                <ColumnHeader v-model="order.flightNumber">
                  {{ $t('flight_number') }}
                </ColumnHeader>
              </th>
              <th scope="col" class="col-2">
                <ColumnHeader v-model="order['airline.name']">
                  {{ $t('airline') }}
                </ColumnHeader>
              </th>
              <th scope="col" class="col-2">
                <ColumnHeader v-model="order['departureAirport.country']">
                  {{ $t('departure_country') }}
                </ColumnHeader>
              </th>
              <th scope="col" class="col-3">
                <ColumnHeader v-model="order['departureAirport.name']">
                  {{ $t('departure_airport') }}
                </ColumnHeader>
              </th>
            </tr>
          </thead>
          <tbody>

            <template v-if="flightsLoaded">
              <tr v-for="flight in flights['hydra:member']" :key="flight.id">
                <td>
                  <RouterLink :to="{ name: 'database_flight', params: {
                    flightNumber: flight.flightNumber } }">
                    {{ flight.flightNumber }}
                  </RouterLink>
                </td>
                <td>
                  <RouterLink :to="{ name: 'database_airline', params: {
                    icaoCode: flight.airline.icaoCode } }">
                    {{ flight.airline.name }}
                  </RouterLink>
                </td>
                <td>
                  <CountryFlag class="me-2" :country-code="flight.departureAirport.country" height="16"/>
                  <CountryName :country-code="flight.departureAirport.country"/>
                </td>
                <td>
                  <RouterLink :to="{ name: 'database_airport', params: {
                    icaoCode: flight.departureAirport.icaoCode } }">
                    {{ flight.departureAirport.name }}
                  </RouterLink>
                </td>
              </tr>
            </template>

            <template v-else>
              <tr v-for="index in $m.range(0, 10).toArray()" :key="index">
                <td>
                  <ContentLoader width="100" height="15"/>
                </td>
                <td>
                  <ContentLoader width="200" height="15"/>
                </td>
                <td>
                  <ContentLoader width="200" height="15"/>
                </td>
                <td>
                  <ContentLoader width="300" height="15"/>
                </td>
              </tr>
            </template>

          </tbody>
        </table>
      </div>
      <Pagination class="mt-3" :items="flights" :itemsLoaded="flightsLoaded" v-model="page"/>
    </template>

    <template v-else>
      <NoDataAvailable/>
    </template>

  </div>
</template>

<script>
import ColumnHeader from '@scripts/components/ColumnHeader'
import ContentLoader from '@scripts/components/ContentLoader'
import CountryFlag from '@scripts/components/CountryFlag'
import CountryName from '@scripts/components/CountryName'
import ListHeader from '@scripts/components/ListHeader'
import NoDataAvailable from '@scripts/components/NoDataAvailable'
import Pagination from '@scripts/components/Pagination'
import FontAwesomeIcon from '@scripts/fontawesome'
import { Flight } from '@scripts/services/api'
import { CancelToken } from 'axios'

export default {
  name: 'Aircrafts',
  components: {
    ColumnHeader,
    ContentLoader,
    CountryFlag,
    CountryName,
    FontAwesomeIcon,
    ListHeader,
    NoDataAvailable,
    Pagination
  },
  props: {
    airport: String
  },
  methods: {
    loadFlights () {
      this.cancelToken?.cancel('Concurrent request')
      this.cancelToken = CancelToken.source()
      this.flightsLoaded = false

      Flight.getFlights({
        cancelToken: this.cancelToken.token,
        params: {
          'arrivalAirport.icaoCode': [this.airport],
          itemsPerPage: 10,
          order: this.order,
          page: this.page,
          properties: {
            ...['id', 'flightNumber'],
            airline: ['icaoCode', 'name'],
            departureAirport: ['country', 'icaoCode', 'name']
          }
        }
      }).then(flights => {
        this.flights = flights
        this.flightsLoaded = true
      })
    }
  },
  watch: {
    order: {
      deep: true,
      handler () {
        this.loadFlights()
      }
    },
    page () {
      this.loadFlights()
    }
  },
  data () {
    return {
      cancelToken: null,
      flights: null,
      flightsLoaded: false,
      order: {},
      page: 1
    }
  },
  mounted () {
    this.loadFlights()
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
