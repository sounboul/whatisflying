<template>
  <div v-if="selection?.airport" class="card card-body">
    <div class="d-flex justify-content-between align-items-start">

      <template v-if="airportLoaded">
        <RouterLink :to="{ name: 'database_airport', params: { icaoCode: airport.icaoCode } }">
          <h2>{{ airport.name }}</h2>
        </RouterLink>
      </template>
      <template v-else>
        <ContentLoader class="mb-3" width="300" height="30.63">
          <rect x="0" y="0" width="300" height="24.5" rx="2" ry="2"/>
        </ContentLoader>
      </template>

      <a class="ms-2 text-reset" href="#" @click.prevent="delete selection.airport">
        <span class="visually-hidden">{{ $t('close_the_airport_details') }}</span>
        <FontAwesomeIcon :icon="['fal', 'xmark']" size="2x" aria-hidden="true"/>
      </a>
    </div>
    <div class="table-responsive">
      <table class="table table-sm mb-0">
        <tbody>
          <tr>
            <th scope="row" class="col-6">{{ $t('icao_code') }}</th>
            <td class="col-6">

              <template v-if="airportLoaded">
                {{ airport.icaoCode }}
              </template>
              <template v-else>
                <ContentLoader width="50" height="14"/>
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
                <ContentLoader width="50" height="14"/>
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
                <ContentLoader width="150" height="14"/>
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
                <ContentLoader width="150" height="14"/>
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
                <ContentLoader width="150" height="14"/>
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
                <ContentLoader width="100" height="14"/>
              </template>

            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <h3 class="mt-3">{{ $t('runways') }}</h3>

    <div v-if="!airportRunwaysLoaded || airportRunways['hydra:totalItems']" class="table-responsive">
      <table class="table table-sm mb-0">
        <thead>
          <tr>
            <th scope="row" class="col-2">{{ $t('runway') }}</th>
            <th scope="row" class="col-3">{{ $t('length') }}</th>
            <th scope="row" class="col-3">{{ $t('width') }}</th>
            <th scope="row" class="col-3">{{ $t('surface') }}</th>
          </tr>
        </thead>
        <tbody>

          <template v-if="airportRunwaysLoaded">
            <tr v-for="airportRunway in airportRunways['hydra:member']" :key="airportRunway.id">
              <td>{{ airportRunway.heName }}/{{ airportRunway.leName }}</td>
              <td>
                {{ $n(airportRunway.length) }}&nbsp;ft /
                {{ $n($m.round($m.unit(airportRunway.length, 'ft').toNumber('m'))) }}&nbsp;m
              </td>
              <td>
                {{ $n(airportRunway.width) }}&nbsp;ft /
                {{ $n($m.round($m.unit(airportRunway.width, 'ft').toNumber('m'))) }}&nbsp;m
              </td>
              <td>

                <template v-if="airportRunway.surface === 'ASP'">
                  {{ $t('asphalt') }}
                </template>
                <template v-else-if="airportRunway.surface === 'BIT'">
                  {{ $t('bituminous_asphalt') }}
                </template>
                <template v-else-if="airportRunway.surface === 'BRI'">
                  {{ $t('bricks') }}
                </template>
                <template v-else-if="airportRunway.surface === 'CLA'">
                  {{ $t('clay') }}
                </template>
                <template v-else-if="airportRunway.surface === 'COM'">
                  {{ $t('composite') }}
                </template>
                <template v-else-if="airportRunway.surface === 'CON'">
                  {{ $t('concrete') }}
                </template>
                <template v-else-if="airportRunway.surface === 'COP'">
                  {{ $t('composite') }}
                </template>
                <template v-else-if="airportRunway.surface === 'COR'">
                  {{ $t('coral') }}
                </template>
                <template v-else-if="airportRunway.surface === 'GRE'">
                  {{ $t('grass_or_earth_graded_rolled') }}
                </template>
                <template v-else-if="airportRunway.surface === 'GRS'">
                  {{ $t('grass_or_earth_non_graded_rolled') }}
                </template>
                <template v-else-if="airportRunway.surface === 'GVL'">
                  {{ $t('gravel') }}
                </template>
                <template v-else-if="airportRunway.surface === 'ICE'">
                  {{ $t('ice') }}
                </template>
                <template v-else-if="airportRunway.surface === 'LAT'">
                  {{ $t('laterite') }}
                </template>
                <template v-else-if="airportRunway.surface === 'MAC'">
                  {{ $t('macadam') }}
                </template>
                <template v-else-if="airportRunway.surface === 'PEM'">
                  {{ $t('partially_asphalt_bituminous_asphalt_or_concrete') }}
                </template>
                <template v-else-if="airportRunway.surface === 'PER'">
                  {{ $t('permanent_surface_details_unknown') }}
                </template>
                <template v-else-if="airportRunway.surface === 'PSP'">
                  {{ $t('pierced_steel_planking') }}
                </template>
                <template v-else-if="airportRunway.surface === 'SAN'">
                  {{ $t('sand') }}
                </template>
                <template v-else-if="airportRunway.surface === 'SMT'">
                  {{ $t('sommerfeld_tracking') }}
                </template>
                <template v-else-if="airportRunway.surface === 'SNO'">
                  {{ $t('snow') }}
                </template>
                <template v-else-if="airportRunway.surface === 'WAT'">
                  {{ $t('water') }}
                </template>
                <template v-else>
                  {{ $t('unknown__f') }}
                </template>

              </td>
            </tr>
          </template>

          <template v-else>
            <tr v-for="index in $m.range(0, 5).toArray()" :key="index">
              <td>
                <ContentLoader width="100" height="14"/>
              </td>
              <td>
                <ContentLoader width="50" height="14"/>
              </td>
              <td>
                <ContentLoader width="50" height="14"/>
              </td>
              <td>
                <ContentLoader width="100" height="14"/>
              </td>
            </tr>
          </template>

        </tbody>
      </table>
    </div>

    <template v-else>
      <NoDataAvailable/>
    </template>

    <h3 class="mt-3">{{ $t('radio_frequencies') }}</h3>

    <div v-if="!airportFrequenciesLoaded || airportFrequencies['hydra:totalItems']" class="table-responsive">
      <table class="table table-sm mb-0">
        <thead>
          <tr>
            <th scope="col" class="col-4">{{ $t('type') }}</th>
            <th scope="col" class="col-4">{{ $t('frequency') }}</th>
            <th scope="col" class="col-4">{{ $t('description') }}</th>
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
                <ContentLoader width="50" height="14"/>
              </td>
              <td>
                <ContentLoader width="100" height="14"/>
              </td>
              <td>
                <ContentLoader width="150" height="14"/>
              </td>
            </tr>
          </template>

        </tbody>
      </table>
    </div>

    <template v-else>
      <NoDataAvailable/>
    </template>

    <h3 class="mt-3">{{ $t('weather') }}</h3>

    <div v-if="user" class="table-responsive">
      <table class="table table-sm mb-0">
        <tbody>
          <tr>
            <th scope="row" class="col-6">{{ $t('weather') }}</th>
            <td class="col-6">

              <template v-if="weatherLoaded">
                {{ weather.weather.map(item => item.description).join(', ') }}
              </template>
              <template v-else>
                <ContentLoader width="100" height="14"/>
              </template>

            </td>
          </tr>
          <tr>
            <th scope="row" class="col-6">{{ $t('temperature') }}</th>
            <td class="col-6">

              <template v-if="weatherLoaded">
                {{ $m.round(weather.main.temp, 1) }}&nbsp;°C /
                {{ $m.round($m.unit(weather.main.temp, 'degC').toNumber('degF'), 1) }}&nbsp;°F

                <div v-if="weather.main.temp_max && weather.main.temp_max !== weather.main.temp" class="mt-2">
                  <span data-bs-toggle="tooltip" :title="$t('highest_temperature_currently_observed')">
                    <FontAwesomeIcon class="me-1" :icon="['far','temperature-high']" aria-hidden="true"/>
                  </span>
                  {{ $m.round(weather.main.temp_max, 1) }}&nbsp;°C /
                  {{ $m.round($m.unit(weather.main.temp_max, 'degC').toNumber('degF'), 1) }}&nbsp;°F
                </div>

                <div v-if="weather.main.temp_min && weather.main.temp_min !== weather.main.temp" class="mt-2">
                  <span data-bs-toggle="tooltip" :title="$t('lowest_temperature_currently_observed')">
                    <FontAwesomeIcon class="me-1" :icon="['far','temperature-low']" aria-hidden="true"/>
                  </span>
                  {{ $m.round(weather.main.temp_min, 1) }}&nbsp;°C /
                  {{ $m.round($m.unit(weather.main.temp_min, 'degC').toNumber('degF'), 1) }}&nbsp;°F
                </div>

              </template>
              <template v-else>
                <ContentLoader width="200" height="58">
                  <rect x="0" y="0" width="100" height="14" rx="2" ry="2"/>
                  <rect x="0" y="22" width="100" height="14" rx="2" ry="2"/>
                  <rect x="0" y="44" width="100" height="14" rx="2" ry="2"/>
                </ContentLoader>
              </template>

            </td>
          </tr>
          <tr>
            <th scope="row" class="col-6">{{ $t('humidity') }}</th>
            <td class="col-6">

              <template v-if="weatherLoaded">
                {{ $m.round(weather.main.humidity) }}&nbsp;%&nbsp;rH
              </template>
              <template v-else>
                <ContentLoader width="50" height="14"/>
              </template>

            </td>
          </tr>
          <tr>
            <th scope="row" class="col-6">{{ $t('wind_direction') }}</th>
            <td class="col-6">

              <template v-if="weatherLoaded">
                {{ $m.round(weather.wind.deg) }}°
              </template>
              <template v-else>
                <ContentLoader width="50" height="14"/>
              </template>

            </td>
          </tr>
          <tr>
            <th scope="row" class="col-6">{{ $t('wind_speed') }}</th>
            <td>

              <template v-if="weatherLoaded">
                {{ $m.round($m.unit(weather.wind.speed, 'm/s').toNumber('kt')) }}&nbsp;kt /
                {{ $m.round($m.unit(weather.wind.speed, 'm/s').toNumber('km/h')) }}&nbsp;km/h /
                {{ $m.round(weather.wind.speed) }}&nbsp;m/s
              </template>
              <template v-else>
                <ContentLoader width="150" height="14"/>
              </template>

            </td>
          </tr>
          <tr>
            <th scope="row" class="col-6">{{ $t('wind_gusts') }}</th>
            <td>

              <template v-if="weatherLoaded">

                <template v-if="weather.wind.gust">
                  {{ $m.round($m.unit(weather.wind.gust, 'm/s').toNumber('kt')) }}&nbsp;kt /
                  {{ $m.round($m.unit(weather.wind.gust, 'm/s').toNumber('km/h')) }}&nbsp;km/h /
                  {{ $m.round(weather.wind.gust) }}&nbsp;m/s
                </template>
                <template v-else>
                  -
                </template>

              </template>
              <template v-else>
                <ContentLoader width="150" height="14"/>
              </template>

            </td>
          </tr>
          <tr>
            <th scope="row" class="col-6">{{ $t('cloud_coverage') }}</th>
            <td class="col-6">

              <template v-if="weatherLoaded">
                {{ weather.clouds.all }}&nbsp;%
              </template>
              <template v-else>
                <ContentLoader width="50" height="14"/>
              </template>

            </td>
          </tr>

          <template v-if="weatherLoaded">

            <tr v-if="weather.main.sea_level">
              <th scope="row" class="col-6">
                <abbr data-bs-toggle="tooltip" :title="$t('atmospheric_pressure_at_mean_sea_level')">
                  {{ $t('qnh') }}
                </abbr>
              </th>
              <td class="col-6">
                {{ $m.round(weather.main.sea_level) }}&nbsp;hPa /
                {{ $m.round($m.unit(weather.main.sea_level, 'hPa').toNumber('inHg'), 2) }}&nbsp;in&nbsp;Hg
              </td>
            </tr>

            <tr v-if="weather.main.grnd_level">
              <th scope="row" class="col-6">
                <abbr data-bs-toggle="tooltip" :title="$t('atmospheric_pressure_at_ground_level')">
                  {{ $t('qfe') }}
                </abbr>
              </th>
              <td class="col-6">
                {{ $m.round(weather.main.grnd_level) }}&nbsp;hPa /
                {{ $m.round($m.unit(weather.main.grnd_level, 'hPa').toNumber('inHg'), 2) }}&nbsp;in&nbsp;Hg
              </td>
            </tr>

          </template>
          <template v-else>
            <tr v-for="index in $m.range(0, 2).toArray()" :key="index">
              <th scope="row" class="col-6">
                <ContentLoader width="100" height="14"/>
              </th>
              <td class="col-6">
                <ContentLoader width="100" height="14"/>
              </td>
            </tr>
          </template>

          <tr>
            <th scope="row" class="col-6">{{ $t('visibility') }}</th>
            <td class="col-6">

              <template v-if="weatherLoaded">
                {{ $m.round($m.unit(weather.visibility, 'm').toNumber('km'), 1) }}&nbsp;km /
                {{ $m.round($m.unit(weather.visibility, 'm').toNumber('nmi'), 1) }}&nbsp;nm /
                {{ $m.round($m.unit(weather.visibility, 'm').toNumber('mi'), 1) }}&nbsp;mi
              </template>
              <template v-else>
                <ContentLoader width="150" height="14"/>
              </template>

            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <template v-else>
      <div class="text-center text-muted mb-3">
        <FontAwesomeIcon class="me-2" :icon="['far', 'lock']" aria-hidden="true"/>
        {{ $t('sign_in_to_unlock_weather') }}
      </div>
    </template>

  </div>
</template>

<script>
import ContentLoader from '@scripts/components/ContentLoader'
import NoDataAvailable from '@scripts/components/NoDataAvailable'
import FontAwesomeIcon from '@scripts/fontawesome'
import { Airport } from '@scripts/services/api'
import { Weather } from '@scripts/services/open-weather-map'
import { CancelToken } from 'axios'
import { mapGetters } from 'vuex'

export default {
  name: 'AirportDetails',
  components: {
    ContentLoader,
    FontAwesomeIcon,
    NoDataAvailable
  },
  inject: ['selection'],
  computed: {
    ...mapGetters(['user'])
  },
  methods: {
    loadAirport () {
      this.airportCancelToken?.cancel('Concurrent request')
      this.airportCancelToken = CancelToken.source()
      this.airportLoaded = false

      Airport.getAirport(this.selection.airport, {
        cancelToken: this.airportCancelToken.token
      }).then(airport => {
        this.airport = airport
        this.airportLoaded = true
      })
    },
    loadAirportFrequencies () {
      this.airportFrequenciesCancelToken?.cancel('Concurrent request')
      this.airportFrequenciesCancelToken = CancelToken.source()
      this.airportFrequenciesLoaded = false

      Airport.getAirportFrequencies(this.selection.airport, {
        cancelToken: this.airportFrequenciesCancelToken.token,
        params: {
          pagination: false
        }
      }).then(airportFrequencies => {
        this.airportFrequencies = airportFrequencies
        this.airportFrequenciesLoaded = true
      })
    },
    loadAirportRunways () {
      this.airportRunwaysCancelToken?.cancel('Concurrent request')
      this.airportRunwaysCancelToken = CancelToken.source()
      this.airportRunwaysLoaded = false

      Airport.getAirportRunways(this.selection.airport, {
        cancelToken: this.airportRunwaysCancelToken.token,
        params: {
          pagination: false
        }
      }).then(airportRunways => {
        this.airportRunways = airportRunways
        this.airportRunwaysLoaded = true
      })
    },
    loadWeather () {
      this.weatherCancelToken?.cancel('Concurrent request')
      this.weatherCancelToken = CancelToken.source()
      this.weatherLoaded = false

      Airport.getAirport(this.selection.airport, {
        cancelToken: this.weatherCancelToken.token,
        params: {
          properties: ['latitude', 'longitude']
        }
      }).then(airport => {
        Weather.getWeather({
          cancelToken: this.weatherCancelToken.token,
          params: {
            lang: this.$i18n.locale,
            lat: airport.latitude,
            lon: airport.longitude
          }
        }).then(weather => {
          this.weather = weather
          this.weatherLoaded = true
        })
      })
    }
  },
  watch: {
    '$i18n.locale' () {
      if (this.user && this.selection?.airport) {
        this.loadWeather()
      }
    },
    selection: {
      deep: true,
      handler (selection) {
        if (selection?.airport) {
          this.loadAirport()
          this.loadAirportFrequencies()
          this.loadAirportRunways()

          if (this.user) {
            this.loadWeather()
          }
        }
      }
    },
    user (user) {
      if (user && this.selection?.airport) {
        this.loadWeather()
      }
    }
  },
  data () {
    return {
      airport: null,
      airportCancelToken: null,
      airportFrequencies: null,
      airportFrequenciesCancelToken: null,
      airportFrequenciesLoaded: false,
      airportLoaded: false,
      airportRunways: null,
      airportRunwaysCancelToken: null,
      airportRunwaysLoaded: false,
      weather: null,
      weatherCancelToken: null,
      weatherLoaded: false
    }
  },
  unmounted () {
    this.airportCancelToken?.cancel('Component unmounted')
    this.airportFrequenciesCancelToken?.cancel('Component unmounted')
    this.airportRunwaysCancelToken?.cancel('Component unmounted')
    this.weatherCancelToken?.cancel('Component unmounted')
  }
}
</script>
