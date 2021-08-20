<template>
  <DefaultLayout>
    <template #content>
      <div class="row g-3">
        <div class="col-xl-8">
          <div class="card h-100 overflow-hidden">

            <Map v-if="airportLoaded" :latitude="airport.latitude" :longitude="airport.longitude" :zoom="13"
                 :force-show-airports="true" :featured-airports="featuredAirports"/>
            <template v-else>
              <ContentLoader width="1400" height="800"/>
            </template>

          </div>
        </div>
        <div class="col-xl-4">
          <div class="card card-body">

            <template v-if="airportLoaded">
              <h1>{{ airport.name }}</h1>
            </template>
            <template v-else>
              <ContentLoader class="mb-3" width="350" height="37.5"/>
            </template>

            <div class="table-responsive">
              <table class="table mb-0">
                <tbody>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('icao_code') }}</th>
                    <td class="col-6">

                      <template v-if="airportLoaded">
                        {{ airport.icaoCode }}
                      </template>
                      <template v-else>
                        <ContentLoader width="100" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('iata_code') }}</th>
                    <td class="col-6">

                      <template v-if="airportLoaded">
                        {{ airport.iataCode || '-' }}
                      </template>
                      <template v-else>
                        <ContentLoader width="100" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('in_service') }}</th>
                    <td class="col-6">

                      <template v-if="airportLoaded">
                        {{ airport.active ? $t('yes') : $t('no') }}
                      </template>
                      <template v-else>
                        <ContentLoader width="100" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('international__m') }}</th>
                    <td class="col-6">

                      <template v-if="airportLoaded">
                        {{ airport.international ? $t('yes') : $t('no') }}
                      </template>
                      <template v-else>
                        <ContentLoader width="100" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">
                      <abbr data-bs-toggle="tooltip" :title="$t('flight_information_region')">
                        {{ $t('fir') }}
                      </abbr>
                    </th>
                    <td class="col-6">

                      <template v-if="airportLoaded">

                        <template v-if="airport.fir">
                          {{ airport.fir.name }} ({{ airport.fir.icaoCode }})
                        </template>
                        <template v-else>
                          -
                        </template>

                      </template>
                      <template v-else>
                        <ContentLoader width="100" height="15"/>
                      </template>

                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card card-body mt-3">
            <h3>{{ $t('location') }}</h3>
            <div class="table-responsive">
              <table class="table mb-0">
                <tbody>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('country') }}</th>
                    <td class="col-6">

                      <template v-if="airportLoaded">
                        <CountryFlag class="me-2" :country-code="airport.country" height="16"/>
                        <CountryName :country-code="airport.country"/>
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
                    <th scope="row" class="col-6">{{ $t('latitude') }}</th>
                    <td class="col-6">

                      <template v-if="airportLoaded">
                        {{ $n($m.round(airport.latitude, 5)) }}° /
                        {{ $dms(airport.latitude) }}
                        {{ airport.latitude >= 0 ? 'N' : 'S' }}
                      </template>
                      <template v-else>
                        <ContentLoader width="200" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('longitude') }}</th>
                    <td class="col-6">

                      <template v-if="airportLoaded">
                        {{ $n($m.round(airport.longitude, 5)) }}° /
                        {{ $dms(airport.longitude) }}
                        {{ airport.longitude >= 0 ? 'E' : 'W' }}
                      </template>
                      <template v-else>
                        <ContentLoader width="200" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('elevation') }}</th>
                    <td class="col-6">

                      <template v-if="airportLoaded">

                        <template v-if="airport.elevation">
                          {{ $n(airport.elevation) }}&nbsp;ft /
                          {{ $n($m.round($m.unit(airport.elevation, 'ft').toNumber('m'))) }}&nbsp;m
                        </template>
                        <template v-else>
                          -
                        </template>

                      </template>
                      <template v-else>
                        <ContentLoader width="200" height="15"/>
                      </template>

                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <AirportRadioFrequencies class="mt-3" :airport="icaoCode"/>
        </div>
        <div class="col-12 col-lg-8">
          <AirportStatistics :airport="icaoCode"/>
        </div>
        <div class="col-12 col-lg-4">
          <AirportWeather :airport="icaoCode"/>
        </div>
        <div class="col-12">
          <AirportRunways :airport="icaoCode"/>
        </div>
        <div class="col-12">
          <AirportNavaids :airport="icaoCode"/>
        </div>
        <div class="col-12">
          <AirportDepartures :airport="icaoCode"/>
        </div>
        <div class="col-12">
          <AirportArrivals :airport="icaoCode"/>
        </div>
      </div>
    </template>
  </DefaultLayout>
</template>

<script>
import ContentLoader from '@scripts/components/ContentLoader'
import CountryFlag from '@scripts/components/CountryFlag'
import CountryName from '@scripts/components/CountryName'
import AirportArrivals from '@scripts/components/database/AirportArrivals'
import AirportDepartures from '@scripts/components/database/AirportDepartures'
import AirportNavaids from '@scripts/components/database/AirportNavaids'
import AirportRadioFrequencies from '@scripts/components/database/AirportRadioFrequencies'
import AirportRunways from '@scripts/components/database/AirportRunways'
import AirportStatistics from '@scripts/components/database/AirportStatistics'
import AirportWeather from '@scripts/components/database/AirportWeather'
import Map from '@scripts/components/Map'
import DefaultLayout from '@scripts/layouts/DefaultLayout'
import { Airport, NotFound } from '@scripts/services/api'
import { CancelToken } from 'axios'
import { mapActions } from 'vuex'

export default {
  name: 'Airport',
  components: {
    AirportArrivals,
    AirportDepartures,
    AirportWeather,
    AirportNavaids,
    AirportRadioFrequencies,
    AirportRunways,
    AirportStatistics,
    ContentLoader,
    CountryFlag,
    CountryName,
    DefaultLayout,
    Map
  },
  props: {
    icaoCode: String
  },
  computed: {
    featuredAirports () {
      const { icaoCode } = this.airport
      return [icaoCode]
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
    loadAirport () {
      this.cancelToken = CancelToken.source()

      Airport.getAirport(this.icaoCode, {
        cancelToken: this.cancelToken.token
      }).then(airport => {
        this.airport = airport
        this.airportLoaded = true
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
      if (this.airportLoaded) {
        const { iataCode = '-', icaoCode, name } = this.airport
        this.setMetaDescription(this.$t('meta_description.airport', { iataCode: iataCode || '-', icaoCode, name }))
      }
    },
    airport: {
      deep: true,
      handler (airport) {
        const { iataCode = '-', icaoCode, name } = airport
        this.setMetaDescription(this.$t('meta_description.airport', { iataCode: iataCode || '-', icaoCode, name }))
        this.setMetaTitle(`${name} - ${icaoCode}/${iataCode || '-'}`)
        this.setPageTitle(`${name} - ${icaoCode}/${iataCode || '-'}`)
      }
    }
  },
  data () {
    return {
      airport: null,
      airportLoaded: false
    }
  },
  mounted () {
    this.setMetaRobots('index,follow,noarchive')
    this.setMetaUrl(this.$route.path)
    this.loadAirport()
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
