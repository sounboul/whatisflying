<template>
  <div v-if="selection?.navaid" class="card card-body">
    <div class="d-flex justify-content-between align-items-start">

      <template v-if="navaidLoaded">
        <RouterLink :to="{ name: 'database_navaid', params: { slug: navaid.slug } }">
          <h2>{{ navaid.name }}</h2>
        </RouterLink>
      </template>
      <template v-else>
        <ContentLoader class="mb-3" width="100" height="30.63">
          <rect x="0" y="0" width="100" height="24.5" rx="2" ry="2"/>
        </ContentLoader>
      </template>

      <a class="ms-2 text-reset" href="#" @click.prevent="delete selection.navaid">
        <span class="visually-hidden">{{ $t('close_the_navaid_details') }}</span>
        <FontAwesomeIcon :icon="['fal', 'xmark']" size="2x" aria-hidden="true"/>
      </a>
    </div>
    <div class="table-responsive">
      <table class="table table-sm mb-0">
        <tbody>
          <tr>
            <th scope="row" class="col-6">{{ $t('identifier') }}</th>
            <td class="col-6">

              <template v-if="navaidLoaded">
                {{ navaid.identifier }}
                <kbd>{{ $morse(navaid.identifier) }}</kbd>
              </template>
              <template v-else>
                <ContentLoader width="50" height="14"/>
              </template>

            </td>
          </tr>
          <tr>
            <th scope="row" class="col-6">{{ $t('type') }}</th>
            <td class="col-6">

              <template v-if="navaidLoaded">
                <NavaidIcon class="me-2" :navaid-type="navaid.type" height="16"/>
                <NavaidType :navaid-type="navaid.type"/>
              </template>
              <template v-else>
                <ContentLoader width="124" height="16">
                  <circle cx="8" cy="8" r="8"/>
                  <rect x="24" y="1" width="100" height="14" rx="2" ry="2"/>
                </ContentLoader>
              </template>

            </td>
          </tr>
          <tr>
            <th scope="row" class="col-6">{{ $t('frequency') }}</th>
            <td class="col-6">

              <template v-if="navaidLoaded">

                <template v-if="navaid.frequency >= 1000">
                  {{ $n($m.round($m.unit(navaid.frequency, 'kHz').toNumber('MHz'), 3)) }}&nbsp;MHz
                </template>
                <template v-else>
                  {{ $n(navaid.frequency) }}&nbsp;kHz
                </template>

              </template>
              <template v-else>
                <ContentLoader width="50" height="14"/>
              </template>

            </td>
          </tr>

          <template v-if="navaidLoaded">

            <tr v-if="navaid.type.match(/^IGS|ILS-I|ILS-II|ILS-III|LDA|LOC|SDF$/)">
              <th scope="row" class="col-6">{{ $t('localizer_magnetic_heading') }}</th>
              <td class="col-6">{{ $n($m.round(navaid.localizerHeading, 2)) }}°</td>
            </tr>

            <tr v-if="navaid.type === 'GS'">
              <th scope="row" class="col-6">{{ $t('glide_slope_angle') }}</th>
              <td class="col-6">{{ $n($m.round(navaid.glideSlopeAngle, 1)) }}°</td>
            </tr>

            <tr v-if="navaid.type.match(/^TACAN|VOR|VOR-DME|VORTAC$/)">
              <th scope="row" class="col-6">{{ $t('vor_slaved_variation') }}</th>
              <td class="col-6">{{ $n($m.round(navaid.vorSlavedVariation, 2)) }}°</td>
            </tr>

            <tr v-if="navaid.type === 'DME-ILS'">
              <th scope="row" class="col-6">{{ $t('dme_bias') }}</th>
              <td class="col-6">

                <template v-if="navaid.dmeBias !== 0">
                  {{ $n($m.round(navaid.dmeBias, 1)) }}&nbsp;nm
                </template>
                <template v-else>
                  -
                </template>

              </td>
            </tr>

            <template v-if="navaid.type.match(/^DME|DME-ILS|DME-NDB|TACAN|VOR-DME|VORTAC$/)">
              <tr>
                <th scope="row" class="col-6">{{ $t('dme_channel') }}</th>
                <td class="col-6">{{ navaid.dmeChannel }}</td>
              </tr>
              <tr>
                <th scope="row" class="col-6">{{ $t('dme_tx_frequency') }}</th>
                <td class="col-6">
                  {{ $n($m.round($m.unit(navaid.dmeTXFrequency, 'kHz').toNumber('MHz'), 3)) }}&nbsp;MHz
                </td>
              </tr>
              <tr>
                <th scope="row" class="col-6">{{ $t('dme_rx_frequency') }}</th>
                <td class="col-6">
                  {{ $n($m.round($m.unit(navaid.dmeRXFrequency, 'kHz').toNumber('MHz'), 3)) }}&nbsp;MHz
                </td>
              </tr>
            </template>

            <tr v-if="!navaid.type.match(/^IM|MM|OM$/)">
              <th scope="row" class="col-6">{{ $t('reception_range') }}</th>
              <td class="col-6">

                <template v-if="navaidLoaded">
                  {{ $n(navaid.receptionRange) }}&nbsp;nm /
                  {{ $n($m.round($m.unit(navaid.receptionRange, 'nmi').toNumber('mi'), 1)) }}&nbsp;mi /
                  {{ $n($m.round($m.unit(navaid.receptionRange, 'nmi').toNumber('km'), 1)) }}&nbsp;km
                </template>
                <template v-else>
                  <ContentLoader width="150" height="14"/>
                </template>

              </td>
            </tr>

          </template>
          <template v-else>
            <tr v-for="index in $m.range(0, 6).toArray()" :key="index">
              <th scope="row" class="col-6">
                <ContentLoader width="100" height="14"/>
              </th>
              <td class="col-6">
                <ContentLoader width="100" height="14"/>
              </td>
            </tr>
          </template>

          <tr>
            <th scope="row" class="col-6">{{ $t('usage') }}</th>
            <td class="col-6">

              <template v-if="navaidLoaded">

                <template v-if="navaid.usage === 'ENROUTE'">
                  {{ $t('en_route_navigation') }}
                </template>
                <template v-else-if="navaid.usage === 'TERMINAL'">
                  {{ $t('terminal_area_navigation') }}
                </template>
                <template v-else>
                  {{ $t('unknown_usage') }}
                </template>

              </template>
              <template v-else>
                <ContentLoader width="150" height="14"/>
              </template>

            </td>
          </tr>
          <tr>
            <th scope="row" class="col-6">{{ $t('icao_region') }}</th>
            <td class="col-6">

              <template v-if="navaidLoaded">
                {{ navaid.region }}
              </template>
              <template v-else>
                <ContentLoader width="50" height="14"/>
              </template>

            </td>
          </tr>

          <template v-if="navaidLoaded">

            <tr v-if="navaid.airport">
              <th scope="row" class="col-6">{{ $t('associated_airport') }}</th>
              <td class="col-6">
                <RouterLink :to="{ name: 'database_airport', params: { icaoCode: navaid.airport.icaoCode } }">
                  {{ navaid.airport.name }}
                </RouterLink>
              </td>
            </tr>

            <tr v-if="navaid.airportRunway">
              <th scope="row" class="col-6">{{ $t('associated_runway') }}</th>
              <td class="col-6">{{ navaid.airportRunway }}</td>
            </tr>

          </template>

        </tbody>
      </table>
    </div>

    <h3 class="mt-3">{{ $t('location') }}</h3>
    <div class="table-responsive">
      <table class="table table-sm mb-0">
        <tbody>
          <tr>
            <th scope="row" class="col-6">{{ $t('country') }}</th>
            <td class="col-6">

              <template v-if="navaidLoaded">
                <CountryFlag class="me-2" :country-code="navaid.country" height="16"/>
                <CountryName :country-code="navaid.country"/>
              </template>
              <template v-else>
                <ContentLoader width="132" height="16">
                  <rect x="0" y="0" width="24" height="16" rx="2" ry="2"/>
                  <rect x="32" y="1" width="100" height="14" rx="2" ry="2"/>
                </ContentLoader>
              </template>

            </td>
          </tr>
          <tr>
            <th scope="row" class="col-6">{{ $t('latitude') }}</th>
            <td class="col-6">

              <template v-if="navaidLoaded">
                {{ $n($m.round(navaid.latitude, 5)) }}° /
                {{ $dms(navaid.latitude) }}
                {{ navaid.latitude >= 0 ? 'N' : 'S' }}
              </template>
              <template v-else>
                <ContentLoader width="150" height="14"/>
              </template>

            </td>
          </tr>
          <tr>
            <th scope="row" class="col-6">{{ $t('longitude') }}</th>
            <td class="col-6">

              <template v-if="navaidLoaded">
                {{ $n($m.round(navaid.longitude, 5)) }}° /
                {{ $dms(navaid.longitude) }}
                {{ navaid.longitude >= 0 ? 'E' : 'W' }}
              </template>
              <template v-else>
                <ContentLoader width="150" height="14"/>
              </template>

            </td>
          </tr>
          <tr>
            <th scope="row" class="col-6">{{ $t('elevation') }}</th>
            <td class="col-6">

              <template v-if="navaidLoaded">

                <template v-if="navaid.elevation">
                  {{ $n(navaid.elevation) }}&nbsp;ft /
                  {{ $n($m.round($m.unit(navaid.elevation, 'ft').toNumber('m'))) }}&nbsp;m
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
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import ContentLoader from '@scripts/components/ContentLoader'
import CountryFlag from '@scripts/components/CountryFlag'
import CountryName from '@scripts/components/CountryName'
import NavaidIcon from '@scripts/components/NavaidIcon'
import NavaidType from '@scripts/components/NavaidType'
import FontAwesomeIcon from '@scripts/fontawesome'
import { Navaid } from '@scripts/services/api'
import { CancelToken } from 'axios'

export default {
  name: 'NavaidDetails',
  components: {
    ContentLoader,
    CountryFlag,
    CountryName,
    FontAwesomeIcon,
    NavaidIcon,
    NavaidType
  },
  inject: ['selection'],
  methods: {
    loadNavaid () {
      this.cancelToken?.cancel('Concurrent request')
      this.cancelToken = CancelToken.source()
      this.navaidLoaded = false

      Navaid.getNavaid(this.selection.navaid, {
        cancelToken: this.cancelToken.token
      }).then(navaid => {
        this.navaid = navaid
        this.navaidLoaded = true
      })
    }
  },
  watch: {
    selection: {
      deep: true,
      handler (selection) {
        if (selection?.navaid) {
          this.loadNavaid()
        }
      }
    }
  },
  data () {
    return {
      cancelToken: null,
      navaid: null,
      navaidLoaded: false
    }
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
