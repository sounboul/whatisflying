<template>
  <DefaultLayout>
    <template #content>
      <div class="row g-3">
        <div class="col-xl-8">
          <div class="card h-100 overflow-hidden">

            <Map v-if="flightLoaded" :featured-airports="featuredAirports" :flight-number="flight.flightNumber"
                 :force-allow-airport-selection="true" :force-show-airports="true" :zoom="18"/>
            <template v-else>
              <ContentLoader width="1400" height="800"/>
            </template>

          </div>
        </div>
        <div class="col-xl-4">
          <div class="card card-body">
            <div class="d-flex justify-content-between">

              <template v-if="flightLoaded">
                <h1 class="mb-0">{{ flight.flightNumber }}</h1>
              </template>
              <template v-else>
                <ContentLoader class="mb-2" width="350" height="37.5"/>
              </template>

              <div v-if="flight?.airline?.logo" class="logo-container">
                <img class="logo" :src="flight.airline.logo.url" alt="">
              </div>

            </div>
            <div class="table-responsive mt-3">
              <table class="table mb-0">
                <tbody>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('airline') }}</th>
                    <td class="col-6">

                      <RouterLink v-if="flightLoaded" :to="{ name: 'database_airline', params: {
                        icaoCode: flight.airline.icaoCode } }">
                        {{ flight.airline.name }}
                      </RouterLink>
                      <template v-else>
                        <ContentLoader width="200" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('departure_country') }}</th>
                    <td class="col-6">

                      <template v-if="flightLoaded">
                        <CountryFlag class="me-2" :country-code="flight.departureAirport.country" height="16"/>
                        <CountryName :country-code="flight.departureAirport.country"/>
                      </template>
                      <template v-else>
                        <ContentLoader width="232" height="16">
                          <rect x="0" y="0" width="24" height="16" rx="2" ry="2"/>
                          <rect x="32" y="0.5" width="200" height="15" rx="2" ry="2"/>
                        </ContentLoader>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('departure_airport') }}</th>
                    <td class="col-6">

                      <RouterLink v-if="flightLoaded" :to="{ name: 'database_airport', params: {
                        icaoCode: flight.departureAirport.icaoCode }}">
                        {{ flight.departureAirport.name }}
                      </RouterLink>
                      <template v-else>
                        <ContentLoader width="200" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('layover_airports') }}</th>
                    <td class="col-6">

                      <template v-if="flightLoaded">

                        <ul v-if="flight.layoverAirports.length" class="list-unstyled mb-0">
                          <li v-for="layoverAirport in flight.layoverAirports" :key="layoverAirport.id">
                            <RouterLink
                              :to="{ name: 'database_airport', params: { icaoCode: layoverAirport.icaoCode }}">
                              {{ layoverAirport.name }}
                            </RouterLink>
                          </li>
                        </ul>
                        <template v-else>
                          -
                        </template>

                      </template>
                      <template v-else>
                        <ContentLoader width="200" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('arrival_country') }}</th>
                    <td class="col-6">

                      <template v-if="flightLoaded">
                        <CountryFlag class="me-2" :country-code="flight.arrivalAirport.country" height="16"/>
                        <CountryName :country-code="flight.arrivalAirport.country"/>
                      </template>
                      <template v-else>
                        <ContentLoader width="232" height="16">
                          <rect x="0" y="0" width="24" height="16" rx="2" ry="2"/>
                          <rect x="32" y="0.5" width="200" height="15" rx="2" ry="2"/>
                        </ContentLoader>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('arrival_airport') }}</th>
                    <td class="col-6">

                      <RouterLink v-if="flightLoaded" :to="{ name: 'database_airport', params: {
                        icaoCode: flight.arrivalAirport.icaoCode }}">
                        {{ flight.arrivalAirport.name }}
                      </RouterLink>
                      <template v-else>
                        <ContentLoader width="150" height="15"/>
                      </template>

                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </template>
  </DefaultLayout>
</template>

<script>
import ContentLoader from '@scripts/components/ContentLoader'
import CountryFlag from '@scripts/components/CountryFlag'
import CountryName from '@scripts/components/CountryName'
import Map from '@scripts/components/Map'
import DefaultLayout from '@scripts/layouts/DefaultLayout'
import { Flight, NotFound } from '@scripts/services/api'
import { CancelToken } from 'axios'
import { mapActions } from 'vuex'

export default {
  name: 'Flight',
  components: {
    CountryName,
    ContentLoader,
    CountryFlag,
    DefaultLayout,
    Map
  },
  props: {
    flightNumber: String
  },
  computed: {
    featuredAirports () {
      const featuredAirports = []
      const { arrivalAirport, departureAirport, layoverAirports } = this.flight

      const { icaoCode: departureAirportIcaoCode } = departureAirport
      featuredAirports.push(departureAirportIcaoCode)

      layoverAirports.forEach(layoverAirport => {
        const { icaoCode } = layoverAirport
        featuredAirports.push(icaoCode)
      })

      const { icaoCode: arrivalAirportIcaoCode } = arrivalAirport
      featuredAirports.push(arrivalAirportIcaoCode)

      return featuredAirports
    }
  },
  methods: {
    ...mapActions([
      'setMetaDescription',
      'setMetaRobots',
      'setMetaTitle',
      'setMetaUrl',
      'setPageTitle'
    ]),
    loadFlight () {
      this.cancelToken = CancelToken.source()

      Flight.getFlight(this.flightNumber, {
        cancelToken: this.cancelToken.token
      }).then(flight => {
        this.flight = flight
        this.flightLoaded = true
      }).catch(error => {
        if (error instanceof NotFound) {
          this.$router.replace({ name: 'not_found' })
          return
        }

        throw error
      })
    }
  },
  watch: {
    '$i18n.locale' () {
      if (this.flightLoaded) {
        const { flightNumber } = this.flight
        this.setMetaDescription(this.$t('meta_description.flight', { flightNumber }))
      }
    },
    flight: {
      deep: true,
      handler (flight) {
        const { arrivalAirport, departureAirport, flightNumber } = flight
        this.setMetaDescription(this.$t('meta_description.flight', { flightNumber }))
        this.setMetaTitle(`${flightNumber} - ${departureAirport.icaoCode}/${arrivalAirport.icaoCode}`)
        this.setPageTitle(`${flightNumber} - ${departureAirport.icaoCode}/${arrivalAirport.icaoCode}`)
      }
    }
  },
  data () {
    return {
      cancelToken: null,
      flight: null,
      flightLoaded: false
    }
  },
  mounted () {
    this.setMetaRobots('index,follow,noarchive')
    this.setMetaUrl(this.$route.path)
    this.loadFlight()
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
