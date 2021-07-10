<template>
  <DefaultLayout>
    <template #content>
      <div class="row g-3">
        <div class="col-xl-8">
          <div class="card h-100 overflow-hidden">
            <div class="carousel-container">

              <template v-if="airlineLoaded">
                <Carousel v-if="airline.pictures.length" :pictures="airline.pictures" height="800px"/>
                <img v-else src="@images/no-picture.webp" alt="">
              </template>
              <template v-else>
                <ContentLoader width="1200" height="800"/>
              </template>

            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <div class="card card-body">
            <div class="d-flex justify-content-between">

              <template v-if="airlineLoaded">
                <h1>{{ airline.name }}</h1>
              </template>
              <template v-else>
                <ContentLoader class="mb-3" width="350" height="37.5"/>
              </template>

              <div v-if="airlineLoaded && airline.logo" class="logo-container">
                <img class="logo" :src="airline.logo.url" alt="">
              </div>

            </div>
            <div class="table-responsive">
              <table class="table mb-0">
                <tbody>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('icao_code') }}</th>
                    <td class="col-6">

                      <template v-if="airlineLoaded">
                        {{ airline.icaoCode }}
                      </template>
                      <template v-else>
                        <ContentLoader width="100" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('iata_code') }}</th>
                    <td class="col-6">

                      <template v-if="airlineLoaded">
                        {{ airline.iataCode || '-' }}
                      </template>
                      <template v-else>
                        <ContentLoader width="100" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('country') }}</th>
                    <td class="col-6">

                      <template v-if="airlineLoaded">
                        <CountryFlag class="me-2" :country-code="airline.country" height="16"/>
                        <CountryName :country-code="airline.country"/>
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
                    <th scope="row" class="col-6">{{ $t('callsign') }}</th>
                    <td class="col-6">

                      <template v-if="airlineLoaded">
                        {{ airline.callsign || '-' }}
                      </template>
                      <template v-else>
                        <ContentLoader width="100" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('active__f') }}</th>
                    <td class="col-6">

                      <template v-if="airlineLoaded">
                        {{ airline.active ? $t('yes') : $t('no') }}
                      </template>
                      <template v-else>
                        <ContentLoader width="50" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('international__f') }}</th>
                    <td class="col-6">

                      <template v-if="airlineLoaded">
                        {{ airline.international ? $t('yes') : $t('no') }}
                      </template>
                      <template v-else>
                        <ContentLoader width="50" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('iata_member') }}</th>
                    <td class="col-6">

                      <template v-if="airlineLoaded">
                        {{ airline.iataMember ? $t('yes') : $t('no') }}
                      </template>
                      <template v-else>
                        <ContentLoader width="50" height="15"/>
                      </template>

                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card card-body mt-3">
            <h3>{{ $t('safety') }}</h3>
            <div class="table-responsive">
              <table class="table mb-0">
                <tbody>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('iosa_certified') }}</th>
                    <td class="col-6">

                      <template v-if="airlineLoaded">
                        {{ airline.iosaCertified ? $t('yes') : $t('no') }}
                      </template>
                      <template v-else>
                        <ContentLoader width="50" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('average_fleet_age') }}</th>
                    <td class="col-6">

                      <template v-if="airlineLoaded">

                        <template v-if="airline.averageFleetAge">
                          {{ $n($m.round(airline.averageFleetAge, 1)) }}
                        </template>
                        <template v-else>
                          -
                        </template>

                      </template>
                      <template v-else>
                        <ContentLoader width="50" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('aircraft_over_25_years_old') }}</th>
                    <td class="col-6">

                      <template v-if="airlineLoaded">

                        <template v-if="airline.aircraftOver25Years">
                          {{ $n(airline.aircraftOver25Years) }}
                        </template>
                        <template v-else>
                          -
                        </template>

                      </template>
                      <template v-else>
                        <ContentLoader width="50" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('accidents_in_the_last_5_years') }}</th>
                    <td class="col-6">

                      <template v-if="airlineLoaded">

                        <template v-if="airline.accidentsLast5Years">
                          {{ $n(airline.accidentsLast5Years) }}
                        </template>
                        <template v-else>
                          -
                        </template>

                      </template>
                      <template v-else>
                        <ContentLoader width="50" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('fatal_accidents_in_the_last_5_years') }}</th>
                    <td class="col-6">

                      <template v-if="airlineLoaded">

                        <template v-if="airline.fatalAccidentsLast5Years">
                          {{ $n(airline.fatalAccidentsLast5Years) }}
                        </template>
                        <template v-else>
                          -
                        </template>

                      </template>
                      <template v-else>
                        <ContentLoader width="50" height="15"/>
                      </template>

                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card card-body mt-3">
            <h3>{{ $t('statistics') }}</h3>
            <div class="table-responsive">
              <table class="table mb-0">
                <tbody>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('destinations') }}</th>
                    <td class="col-6">

                      <template v-if="airlineLoaded">

                        <template v-if="airline.destinations">
                          {{ $n(airline.destinations) }}
                        </template>
                        <template v-else>
                          -
                        </template>

                      </template>
                      <template v-else>
                        <ContentLoader width="50" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('annual_domestic_flights') }}</th>
                    <td class="col-6">

                      <template v-if="airlineLoaded">

                        <template v-if="airline.annualDomesticFlights">
                          {{ $n(airline.annualDomesticFlights) }}
                        </template>
                        <template v-else>
                          -
                        </template>

                      </template>
                      <template v-else>
                        <ContentLoader width="50" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('annual_international_flights') }}</th>
                    <td class="col-6">

                      <template v-if="airlineLoaded">

                        <template v-if="airline.annualInternationalFlights">
                          {{ $n(airline.annualInternationalFlights) }}
                        </template>
                        <template v-else>
                          -
                        </template>

                      </template>
                      <template v-else>
                        <ContentLoader width="50" height="15"/>
                      </template>

                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-12">
          <AirlineFleet :airline="icaoCode"/>
        </div>
        <div class="col-12">
          <AirlineFlights :airline="icaoCode"/>
        </div>
      </div>
    </template>
  </DefaultLayout>
</template>

<script>
import Carousel from '@scripts/components/Carousel'
import ContentLoader from '@scripts/components/ContentLoader'
import CountryFlag from '@scripts/components/CountryFlag'
import CountryName from '@scripts/components/CountryName'
import AirlineFleet from '@scripts/components/database/AirlineFleet'
import AirlineFlights from '@scripts/components/database/AirlineFlights'
import DefaultLayout from '@scripts/layouts/DefaultLayout'
import { Airline, NotFound } from '@scripts/services/api'
import { CancelToken } from 'axios'
import { mapActions } from 'vuex'

export default {
  name: 'Airline',
  components: {
    AirlineFleet,
    AirlineFlights,
    Carousel,
    ContentLoader,
    CountryFlag,
    CountryName,
    DefaultLayout
  },
  props: {
    icaoCode: String
  },
  methods: {
    ...mapActions([
      'setMetaDescription',
      'setMetaImages',
      'setMetaRobots',
      'setMetaTitle',
      'setMetaUrl',
      'setPageTitle'
    ]),
    loadAirline () {
      this.cancelToken = CancelToken.source()

      Airline.getAirline(this.icaoCode, {
        cancelToken: this.cancelToken.token
      }).then(airline => {
        this.airline = airline
        this.airlineLoaded = true
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
      if (this.airlineLoaded) {
        const { iataCode = '-', icaoCode, name } = this.airline
        this.setMetaDescription(this.$t('meta_description.airline', { iataCode: iataCode || '-', icaoCode, name }))
      }
    },
    airline: {
      deep: true,
      handler (airline) {
        const { iataCode = '-', icaoCode, name } = airline
        this.setMetaDescription(this.$t('meta_description.airline', { iataCode: iataCode || '-', icaoCode, name }))
        this.setMetaImages(airline.pictures)
        this.setMetaTitle(`${name} - ${icaoCode}/${iataCode || '-'}`)
        this.setPageTitle(`${name} - ${icaoCode}/${iataCode || '-'}`)
      }
    }
  },
  data () {
    return {
      airline: null,
      airlineLoaded: false
    }
  },
  mounted () {
    this.setMetaRobots('index,follow,noarchive')
    this.setMetaUrl(this.$route.path)
    this.loadAirline()
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
