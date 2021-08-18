<template>
  <div class="card card-body">
    <div class="d-flex justify-content-between">
      <h2>{{ $t('navaids') }}</h2>
      <RouterLink :to="{ name: 'database_navaids', query: {
          'airport.icaoCode': [ $props.airport ] } }">
        <span class="visually-hidden">{{ $t('maximize') }}</span>
        <FontAwesomeIcon :icon="['far', 'arrows-maximize']" aria-hidden="true"/>
      </RouterLink>
    </div>

    <template v-if="navaidsLoaded">

      <div v-if="navaids['hydra:totalItems']" class="row g-3" :data-uuid="this.uuid">
        <div v-for="navaid in navaids['hydra:member']" :key="navaid.id" class="col-xl-4">
          <div class="card card-body">
            <h3>
              <RouterLink :to="{ name: 'database_navaid', params: { slug: navaid.slug } }">
                {{ navaid.name }}
              </RouterLink>
            </h3>
            <div class="table-responsive">
              <table class="table mb-0">
                <tbody>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('identifier') }}</th>
                    <td class="col-6">
                      {{ navaid.identifier }}
                      <kbd>{{ $morse(navaid.identifier) }}</kbd>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('type') }}</th>
                    <td class="col-6">
                      <NavaidIcon class="me-2" :navaid-type="navaid.type" height="16"/>
                      <NavaidType :navaid-type="navaid.type"/>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('frequency') }}</th>
                    <td class="col-6">

                      <template v-if="navaid.frequency >= 1000">
                        {{ $n($m.unit(navaid.frequency, 'kHz').toNumber('MHz')) }}&nbsp;MHz
                      </template>
                      <template v-else>
                        {{ $n(navaid.frequency) }}&nbsp;kHz
                      </template>

                    </td>
                  </tr>

                  <tr v-if="navaid.type.match(/^IGS|ILS-I|ILS-II|ILS-III|LDA|LOC|SDF$/)">
                    <th scope="row" class="col-6">{{ $t('localizer_magnetic_heading') }}</th>
                    <td class="col-6">{{ $n(navaid.localizerHeading) }}°</td>
                  </tr>

                  <tr v-if="navaid.type === 'GS'">
                    <th scope="row" class="col-6">{{ $t('glide_slope_angle') }}</th>
                    <td class="col-6">{{ navaid.glideSlopeAngle }}°</td>
                  </tr>

                  <tr v-if="navaid.type === 'DME-ILS'">
                    <th scope="row" class="col-6">{{ $t('dme_bias') }}</th>
                    <td class="col-6">

                      <template v-if="navaid.dmeBias !== 0">
                        {{ $n($m.unit(navaid.dmeBias, 'm').toNumber('ft')) }}&nbsp;ft
                        {{ $n(navaid.dmeBias) }}&nbsp;m
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
                      <td class="col-6">{{ $n($m.unit(navaid.dmeTXFrequency, 'kHz').toNumber('MHz')) }}&nbsp;MHz</td>
                    </tr>
                    <tr>
                      <th scope="row" class="col-6">{{ $t('dme_rx_frequency') }}</th>
                      <td class="col-6">{{ $n($m.unit(navaid.dmeRXFrequency, 'kHz').toNumber('MHz')) }}&nbsp;MHz</td>
                    </tr>
                  </template>

                  <tr v-if="!navaid.type.match(/^IM|MM|OM$/)">
                    <th scope="row" class="col-6">{{ $t('reception_range') }}</th>
                    <td class="col-6">
                      {{ $n(navaid.receptionRange) }}&nbsp;nm /
                      {{ $n($m.round($m.unit(navaid.receptionRange, 'nmi').toNumber('mi'), 1)) }}&nbsp;mi /
                      {{ $n($m.round($m.unit(navaid.receptionRange, 'nmi').toNumber('km'), 1)) }}&nbsp;km
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
      <div v-for="index in $m.range(0, 6).toArray()" :key="index" class="col-xl-4">
        <div class="card card-body">
          <ContentLoader class="mb-3" width="100" height="22.5"/>
          <div class="table-responsive">
            <table class="table mb-0">
              <tbody>

                <tr v-for="index in $m.range(0, 6).toArray()" :key="index">
                  <th scope="row" class="col-6">
                    <ContentLoader width="150" height="15"/>
                  </th>
                  <td class="col-6">
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
import NavaidIcon from '@scripts/components/NavaidIcon'
import NavaidType from '@scripts/components/NavaidType'
import NoDataAvailable from '@scripts/components/NoDataAvailable'
import FontAwesomeIcon from '@scripts/fontawesome'
import { Navaid } from '@scripts/services/api'
import { CancelToken } from 'axios'
import Masonry from 'masonry-layout'
import * as uuid from 'uuid'

export default {
  name: 'AirportNavaids',
  components: {
    ContentLoader,
    FontAwesomeIcon,
    NavaidIcon,
    NavaidType,
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
    loadNavaids () {
      this.cancelToken?.cancel('Concurrent request')
      this.cancelToken = CancelToken.source()
      this.navaidsLoaded = false

      Navaid.getNavaids({
        cancelToken: this.cancelToken.token,
        params: {
          'airport.icaoCode': this.airport,
          pagination: false
        }
      }).then(navaids => {
        this.navaids = navaids
        this.navaidsLoaded = true
      })
    }
  },
  data () {
    return {
      cancelToken: null,
      masonry: null,
      navaids: null,
      navaidsLoaded: false,
      uuid: uuid.v4()
    }
  },
  mounted () {
    this.loadNavaids()
  },
  updated () {
    this.setupMasonry()
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
