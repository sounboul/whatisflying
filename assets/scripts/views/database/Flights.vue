<template>
  <DatabaseLayout>

    <template #header>
      <h1 class="card-title">{{ $t('flights') }}</h1>
      <ListHeader :items="flights" :items-loaded="flightsLoaded"/>
    </template>

    <template #filters>
      <div class="row g-3">
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterFlightNumber">{{ $t('label.flight_number') }}</label>
          <input class="form-control" id="filterFlightNumber" type="text"
                 :placeholder="$t('enter_a_flight_number')" v-model="filters.flightNumber">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterAirline">{{ $t('label.airline') }}</label>
          <AirlineSelect id="filterAirline" mode="multiple" v-model="filters['airline.icaoCode']"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterDepartureAirport">{{ $t('label.departure_airport') }}</label>
          <AirportSelect id="filterDepartureAirport" mode="multiple" v-model="filters['departureAirport.icaoCode']"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterArrivalAirport">{{ $t('label.arrival_airport') }}</label>
          <AirportSelect id="filterArrivalAirport" mode="multiple" v-model="filters['arrivalAirport.icaoCode']"/>
        </div>
      </div>
      <div class="d-flex justify-content-center mt-5">
        <button class="btn btn-outline-primary" type="button" @click="resetFilters">
          {{ $t('reset_filters') }}
        </button>
      </div>
    </template>

    <template #sort>
      <div class="row g-3">
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="orderFlightNumber">{{ $t('label.flight_number') }}</label>
          <OrderSelect id="orderFlightNumber" v-model="order.flightNumber"/>
        </div>
      </div>
    </template>

    <template #gridView>
      <div v-if="flightsLoaded" class="row g-3">
        <div v-for="flight in flights['hydra:member']" :key="flight.id"
             class="col-md-6 col-xl-3 d-flex flex-column">
          <div class="card h-100">
            <RouterLink :to="{ name: 'database_flight', params: { flightNumber: flight.flightNumber } }">
              <div class="card-img-top overflow-hidden" :style="{ height: '250px' }">
                <StaticMap class="img-cover" width="900" height="500" :params="getMapParams(flight)"/>
              </div>
            </RouterLink>
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div class="overflow-hidden">
                  <h4 class="card-title text-truncate">
                    <RouterLink :to="{ name: 'database_flight', params: { flightNumber: flight.flightNumber } }">
                      {{ flight.flightNumber }}
                    </RouterLink>
                  </h4>
                  <div class="card-subtitle">
                    {{ flight.airline.name }}
                  </div>
                </div>

                <div v-if="flight.airline.logo" class="logo-container">
                  <img class="logo" :src="flight.airline.logo.url" alt="">
                </div>

              </div>
              <div class="mt-3 small text-truncate">
                <div data-bs-toggle="tooltip" :title="getCountryName(flight.departureAirport.country)">
                  <CountryFlag class="me-2" :country-code="flight.departureAirport.country" height="16"/>
                  {{ flight.departureAirport.name }}
                </div>
                <div class="mt-1" data-bs-toggle="tooltip" :title="getCountryName(flight.arrivalAirport.country)">
                  <CountryFlag class="me-2" :country-code="flight.arrivalAirport.country" height="16"/>
                  {{ flight.arrivalAirport.name }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="row g-3">
        <div v-for="index in $m.range(0, 24).toArray()" :key="index"
             class="col-md-6 col-lg-4 col-xl-3 d-flex flex-column">
          <div class="card">
            <div class="card-img-top overflow-hidden" :style="{ height: '250px' }">
              <ContentLoader width="730" height="250">
                <rect x="0" y="0" width="730" height="250"/>
              </ContentLoader>
            </div>
            <div class="card-body">
              <ContentLoader width="730" height="100">
                <rect x="0" y="0" width="100" height="18.75" rx="2" ry="2"/>
                <rect x="0" y="25.43" width="200" height="15" rx="2" ry="2"/>
                <rect x="0" y="60.93" width="24" height="16" rx="2" ry="2"/>
                <rect x="32" y="62.3675" width="100" height="13.125" rx="2" ry="2"/>
                <rect x="0" y="82.46" width="24" height="16" rx="2" ry="2"/>
                <rect x="32" y="83.8975" width="100" height="13.125" rx="2" ry="2"/>
              </ContentLoader>
            </div>
          </div>
        </div>
      </div>

    </template>

    <template #listView>
      <!-- @bug: Workaround for bug https://github.com/vuejs/vue-next/issues/3569 -->
      <div class="card card-body" :key="1">
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
                  <ColumnHeader v-model="order['departureAirport.country']">
                    {{ $t('departure_country') }}
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-3">
                  <ColumnHeader v-model="order['departureAirport.name']">
                    {{ $t('departure_airport') }}
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-2">
                  <ColumnHeader v-model="order['arrivalAirport.country']">
                    {{ $t('arrival_country') }}
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-3">
                  <ColumnHeader v-model="order['arrivalAirport.name']">
                    {{ $t('arrival_airport') }}
                  </ColumnHeader>
                </th>
              </tr>
            </thead>
            <tbody>

              <template v-if="flightsLoaded">
                <tr v-for="flight in flights['hydra:member']" :key="flight.id">
                  <td>
                    <RouterLink :to="{ name: 'database_flight', params: { flightNumber: flight.flightNumber } }">
                      {{ flight.flightNumber }}
                    </RouterLink>
                  </td>
                  <td>
                    <CountryFlag class="me-2" :country-code="flight.arrivalAirport.country" height="16"/>
                    <CountryName :country-code="flight.arrivalAirport.country"/>
                  </td>
                  <td>{{ flight.departureAirport.name }}</td>
                  <td>
                    <CountryFlag class="me-2" :country-code="flight.arrivalAirport.country" height="16"/>
                    <CountryName :country-code="flight.arrivalAirport.country"/>
                  </td>
                  <td>{{ flight.arrivalAirport.name }}</td>
                </tr>
              </template>

              <template v-else>
                <tr v-for="index in $m.range(0, 24).toArray()" :key="index">
                  <td>
                    <ContentLoader width="100" height="15"/>
                  </td>
                  <td>
                    <ContentLoader width="232" height="16">
                      <rect x="0" y="0" width="24" height="16" rx="2" ry="2"/>
                      <rect x="32" y="0.5" width="200" height="15" rx="2" ry="2"/>
                    </ContentLoader>
                  </td>
                  <td>
                    <ContentLoader width="300" height="15"/>
                  </td>
                  <td>
                    <ContentLoader width="232" height="16">
                      <rect x="0" y="0" width="24" height="16" rx="2" ry="2"/>
                      <rect x="32" y="0.5" width="200" height="15" rx="2" ry="2"/>
                    </ContentLoader>
                  </td>
                  <td>
                    <ContentLoader width="300" height="15"/>
                  </td>
                </tr>
              </template>

            </tbody>
          </table>
        </div>
      </div>
    </template>

    <template #pagination>
      <Pagination :items="flights" :items-loaded="flightsLoaded" v-model="page"/>
    </template>

  </DatabaseLayout>
</template>

<script>
import ColumnHeader from '@scripts/components/ColumnHeader'
import ContentLoader from '@scripts/components/ContentLoader'
import CountryFlag from '@scripts/components/CountryFlag'
import CountryName from '@scripts/components/CountryName'
import AirlineSelect from '@scripts/components/form/fields/AirlineSelect'
import AirportSelect from '@scripts/components/form/fields/AirportSelect'
import OrderSelect from '@scripts/components/form/fields/OrderSelect'
import ListHeader from '@scripts/components/ListHeader'
import Pagination from '@scripts/components/Pagination'
import StaticMap from '@scripts/components/StaticMap'
import DatabaseLayout from '@scripts/layouts/DatabaseLayout'
import { Flight } from '@scripts/services/api'
import Country from '@scripts/services/country'
import { CancelToken } from 'axios'
import { mapActions } from 'vuex'

export default {
  name: 'Flights',
  components: {
    AirlineSelect,
    AirportSelect,
    ColumnHeader,
    ContentLoader,
    CountryFlag,
    CountryName,
    DatabaseLayout,
    ListHeader,
    OrderSelect,
    Pagination,
    StaticMap
  },
  methods: {
    ...mapActions([
      'setMetaDescription',
      'setMetaRobots',
      'setMetaTitle',
      'setMetaUrl',
      'setPageTitle'
    ]),
    getCountryName (countryCode) {
      let countryName = Country.getCountryName(countryCode)
      const countryNativeName = Country.getCountryNativeName(countryCode)

      if (countryName !== countryNativeName) {
        countryName += ` (${countryNativeName})`
      }

      return countryName
    },
    getMapParams (flight) {
      const coordinates = []
      const { arrivalAirport, departureAirport, layoverAirports } = flight

      const { latitude: departureLatitude, longitude: departureLongitude } = departureAirport
      coordinates.push(departureLatitude, departureLongitude)

      layoverAirports.forEach(layoverAirport => {
        const { latitude, longitude } = layoverAirport
        coordinates.push(latitude, longitude)
      })

      const { latitude: arrivalLatitude, longitude: arrivalLongitude } = arrivalAirport
      coordinates.push(arrivalLatitude, arrivalLongitude)

      return {
        lw: 4,
        r: coordinates.join(',')
      }
    },
    loadFlights () {
      this.cancelToken?.cancel('Concurrent request')
      this.cancelToken = CancelToken.source()
      this.flightsLoaded = false

      Flight.getFlights({
        cancelToken: this.cancelToken.token,
        params: {
          ...this.filters,
          order: this.order,
          page: this.page,
          properties: {
            ...['id', 'flightNumber'],
            arrivalAirport: ['country', 'latitude', 'longitude', 'name'],
            departureAirport: ['country', 'latitude', 'longitude', 'name'],
            layoverAirports: ['country', 'latitude', 'longitude', 'name'],
            airline: {
              ...['name'],
              logo: ['url']
            }
          }
        }
      }).then(flights => {
        this.flights = flights
        this.flightsLoaded = true
      })
    },
    parseQuery (query = {}) {
      const {
        'airline.icaoCode': airline = [],
        'arrivalAirport.icaoCode': arrivalAirport = [],
        'departureAirport.icaoCode': departureAirport = [],
        flightNumber = null,
        order = {},
        page = 1
      } = query

      this.filters = {
        'airline.icaoCode': airline,
        'arrivalAirport.icaoCode': arrivalAirport,
        'departureAirport.icaoCode': departureAirport,
        flightNumber
      }

      this.order = { ...order }
      this.page = page
    },
    resetFilters () {
      this.filters = {}
      this.page = 1
    }
  },
  watch: {
    '$i18n.locale': {
      immediate: true,
      handler () {
        this.setMetaDescription(this.$t('meta_description.flights'))
        this.setMetaTitle(this.$t('flights'))
        this.setPageTitle(this.$t('flights'))
      }
    },
    '$route.query': {
      deep: true,
      immediate: true,
      handler (query) {
        if (this.$route.name === 'database_flights') {
          this.parseQuery(query)
          this.loadFlights()
        }
      }
    },
    filters: {
      deep: true,
      handler (filters, oldFilters) {
        if (filters === oldFilters) {
          this.page = 1
        }

        this.$router.push({
          name: 'database_flights',
          query: {
            ...filters,
            order: this.order,
            page: this.page
          }
        })
      }
    },
    order: {
      deep: true,
      handler (order) {
        this.$router.push({
          name: 'database_flights',
          query: {
            ...this.filters,
            order,
            page: this.page
          }
        })
      }
    },
    page (page) {
      this.$router.push({
        name: 'database_flights',
        query: {
          ...this.filters,
          order: this.order,
          page
        }
      })
    }
  },
  data () {
    return {
      cancelToken: null,
      filters: {},
      flights: null,
      flightsLoaded: false,
      order: {},
      page: 1
    }
  },
  mounted () {
    this.setMetaRobots('index,follow,noarchive,noimageindex')
    this.setMetaUrl(this.$route.path)
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
