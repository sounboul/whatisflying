<template>
  <div class="card card-body">
    <h2>{{ $t('runways') }}</h2>

    <template v-if="airportRunwaysLoaded">

      <div v-if="airportRunways['hydra:totalItems']" class="row g-3">
        <div v-for="airportRunway in airportRunways['hydra:member']" :key="airportRunway.id" class="col-xl-6">
          <div class="card card-body">
            <h3>{{ airportRunway.heName }}/{{ airportRunway.leName }}</h3>
            <div class="table-responsive">
              <table class="table">
                <tbody>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('length') }}</th>
                    <td class="col-6">
                      {{ $n(airportRunway.length) }}&nbsp;ft /
                      {{ $n($m.round($m.unit(airportRunway.length, 'ft').toNumber('m'))) }}&nbsp;m
                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('width') }}</th>
                    <td class="col-6">
                      {{ $n(airportRunway.width) }}&nbsp;ft /
                      {{ $n($m.round($m.unit(airportRunway.width, 'ft').toNumber('m'))) }}&nbsp;m
                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('surface') }}</th>
                    <td class="col-6">

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
                  <tr>
                    <th scope="row" class="col-6">{{ $t('in_service') }}</th>
                    <td class="col-6">{{ airportRunway.active ? $t('yes') : $t('no') }}</td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('lighted__f') }}</th>
                    <td class="col-6">{{ airportRunway.lighted ? $t('yes') : $t('no') }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="table-responsive">
              <table class="table mb-0">
                <tbody>
                  <tr>
                    <th scope="col" class="col-4"></th>
                    <th scope="col" class="col-4">{{ airportRunway.heName }}</th>
                    <th scope="col" class="col-4">{{ airportRunway.leName }}</th>
                  </tr>
                  <tr>
                    <th scope="row" class="col-4">{{ $t('latitude') }}</th>
                    <td class="col-4">
                      {{ $n($m.round(airportRunway.heLatitude, 5)) }}° /
                      {{ $dms(airportRunway.heLatitude) }}
                      {{ airportRunway.heLatitude >= 0 ? 'NE' : 'S' }}
                    </td>
                    <td class="col-4">
                      {{ $n($m.round(airportRunway.leLatitude, 5)) }}° /
                      {{ $dms(airportRunway.leLatitude) }}
                      {{ airportRunway.leLatitude >= 0 ? 'N' : 'S' }}
                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-4">{{ $t('longitude') }}</th>
                    <td class="col-4">
                      {{ $n($m.round(airportRunway.heLongitude, 5)) }}° /
                      {{ $dms(airportRunway.heLongitude) }}
                      {{ airportRunway.heLongitude >= 0 ? 'E' : 'W' }}
                    </td>
                    <td class="col-4">
                      {{ $n($m.round(airportRunway.leLongitude, 5)) }}° /
                      {{ $dms(airportRunway.leLongitude) }}
                      {{ airportRunway.leLongitude >= 0 ? 'E' : 'W' }}
                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-4">{{ $t('elevation') }}</th>
                    <td class="col-4">

                      <template v-if="airportRunway.heElevation">
                        {{ $n(airportRunway.heElevation) }}&nbsp;ft /
                        {{ $n($m.round($m.unit(airportRunway.heElevation, 'ft').toNumber('m'))) }}&nbsp;m
                      </template>
                      <template v-else>
                        -
                      </template>

                    </td>
                    <td class="col-4">

                      <template v-if="airportRunway.leElevation">
                        {{ $n(airportRunway.leElevation) }}&nbsp;ft /
                        {{ $n($m.round($m.unit(airportRunway.leElevation, 'ft').toNumber('m'))) }}&nbsp;m
                      </template>
                      <template v-else>
                        -
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-4">{{ $t('magnetic_heading') }}</th>
                    <td class="col-4">

                      <template v-if="airportRunway.heHeading">
                        {{ $n(airportRunway.heHeading) }}°
                      </template>
                      <template v-else>
                        -
                      </template>

                    </td>
                    <td class="col-4">

                      <template v-if="airportRunway.leHeading">
                        {{ $n(airportRunway.leHeading) }}°
                      </template>
                      <template v-else>
                        -
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-4">{{ $t('displaced_threshold') }}</th>
                    <td class="col-4">

                      <template v-if="airportRunway.heDisplacedThreshold">
                        {{ $n(airportRunway.heDisplacedThreshold) }}&nbsp;ft /
                        {{ $n($m.round($m.unit(airportRunway.heDisplacedThreshold, 'ft').toNumber('m'))) }}&nbsp;m
                      </template>
                      <template v-else>
                        -
                      </template>

                    </td>
                    <td class="col-4">

                      <template v-if="airportRunway.leDisplacedThreshold">
                        {{ $n(airportRunway.leDisplacedThreshold) }}&nbsp;ft /
                        {{ $n($m.round($m.unit(airportRunway.leDisplacedThreshold, 'ft').toNumber('m'))) }}&nbsp;m
                      </template>
                      <template v-else>
                        -
                      </template>

                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <template v-else>
        <NoDataAvailable/>
      </template>

    </template>

    <div v-else class="row g-3">
      <div v-for="index in $m.range(0, 6).toArray()" :key="index" class="col-xl-6">
        <div class="card card-body">
          <ContentLoader class="mb-3" width="150" height="22.5"/>
          <div class="table-responsive">
            <table class="table">
              <tbody>

                <tr v-for="index in $m.range(0, 5).toArray()" :key="index">
                  <th scope="row" class="col-6">
                    <ContentLoader width="50" height="15"/>
                  </th>
                  <td class="col-6">
                    <ContentLoader width="150" height="15"/>
                  </td>
                </tr>

              </tbody>
            </table>
          </div>
          <div class="table-responsive">
            <table class="table mb-0">
              <tbody>
                <tr>
                  <th scope="col" class="col-4"></th>
                  <th scope="col" class="col-4">
                    <ContentLoader width="50" height="15"/>
                  </th>
                  <th scope="col" class="col-4">
                    <ContentLoader width="50" height="15"/>
                  </th>
                </tr>

                <tr v-for="index in $m.range(0, 5).toArray()" :key="index">
                  <th scope="row" class="col-4">
                    <ContentLoader width="100" height="15"/>
                  </th>
                  <td class="col-4">
                    <ContentLoader width="150" height="15"/>
                  </td>
                  <td class="col-4">
                    <ContentLoader width="150" height="15"/>
                  </td>
                </tr>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import ContentLoader from '@scripts/components/ContentLoader'
import NoDataAvailable from '@scripts/components/NoDataAvailable'
import { Airport } from '@scripts/services/api'
import { CancelToken } from 'axios'
import Masonry from 'masonry-layout'
import * as uuid from 'uuid'

export default {
  name: 'AirportRunways',
  components: {
    ContentLoader,
    NoDataAvailable
  },
  props: {
    airport: String
  },
  methods: {
    setupMasonry () {
      const grid = document.querySelector(`[data-uuid="${this.uuid}"]`)
      if (grid) {
        this.masonry = new Masonry(grid, {
          percentPosition: true
        })
      }
    },
    loadAirportRunways () {
      this.cancelToken?.cancel('Concurrent request')
      this.cancelToken = CancelToken.source()
      this.airportRunwaysLoaded = false

      Airport.getAirportRunways(this.airport, {
        cancelToken: this.cancelToken.token,
        params: {
          pagination: false
        }
      }).then(airportRunways => {
        this.airportRunways = airportRunways
        this.airportRunwaysLoaded = true
      })
    }
  },
  data () {
    return {
      airportRunways: null,
      airportRunwaysLoaded: false,
      cancelToken: null,
      uuid: uuid.v4()
    }
  },
  mounted () {
    this.loadAirportRunways()
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
