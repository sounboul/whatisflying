<template>
  <div class="card card-body">
    <h3>{{ $t('weather') }}</h3>

    <div v-if="user" class="table-responsive">
      <table class="table mb-0">
        <tbody>
          <tr>
            <th scope="row" class="col-6">{{ $t('weather') }}</th>
            <td class="col-6">

              <template v-if="weatherLoaded">
                {{ weather.weather.map(item => item.description).join(', ') }}
              </template>
              <template v-else>
                <ContentLoader width="100" height="15"/>
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
                  <rect x="0" y="0" width="100" height="15" rx="2" ry="2"/>
                  <rect x="0" y="22" width="100" height="15" rx="2" ry="2"/>
                  <rect x="0" y="44" width="100" height="15" rx="2" ry="2"/>
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
                <ContentLoader width="50" height="15"/>
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
                <ContentLoader width="50" height="15"/>
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
                <ContentLoader width="150" height="15"/>
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
                <ContentLoader width="150" height="15"/>
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
                <ContentLoader width="50" height="15"/>
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
                <ContentLoader width="100" height="15"/>
              </th>
              <td class="col-6">
                <ContentLoader width="100" height="15"/>
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
                <ContentLoader width="150" height="15"/>
              </template>

            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <template v-else>
      <div class="text-center text-muted mb-3">
        <FontAwesomeIcon :icon="['far', 'lock']" aria-hidden="true"/>
        {{ $t('sign_in_to_unlock_weather') }}
      </div>
    </template>

  </div>
</template>

<script>
import ContentLoader from '@scripts/components/ContentLoader'
import FontAwesomeIcon from '@scripts/fontawesome'
import { Airport } from '@scripts/services/api'
import { Weather } from '@scripts/services/open-weather-map'
import { CancelToken } from 'axios'
import { mapGetters } from 'vuex'

export default {
  name: 'AirportWeather',
  components: {
    ContentLoader,
    FontAwesomeIcon
  },
  props: {
    airport: String
  },
  computed: {
    ...mapGetters(['user'])
  },
  methods: {
    loadWeather () {
      this.cancelToken?.cancel('Concurrent request')
      this.cancelToken = CancelToken.source()
      this.weatherLoaded = false

      Airport.getAirport(this.airport, {
        cancelToken: this.cancelToken.token,
        params: {
          properties: ['latitude', 'longitude']
        }
      }).then(airport => {
        Weather.getWeather({
          cancelToken: this.cancelToken.token,
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
    user: {
      immediate: true,
      handler (user) {
        if (user) {
          this.loadWeather()
        }
      }
    }
  },
  data () {
    return {
      cancelToken: null,
      weather: null,
      weatherLoaded: false
    }
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
