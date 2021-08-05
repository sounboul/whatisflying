<template>
  <div v-if="selection.value?.aircraft" class="card position-relative">
    <div class="position-absolute top-0 end-0 p-3" style="z-index: 900;">
      <button class="map-control map-control-small" :aria-label="$t('close_the_aircraft_details')"
              @click="delete selection.value.aircraft">
        <FontAwesomeIcon :icon="['fal', 'xmark']" aria-hidden="true"/>
      </button>
    </div>
    <div class="card-img-top overflow-hidden" :style="{ height: '250px' }">

      <template v-if="aircraftLoaded">

        <Carousel v-if="aircraft?.pictures.length" :pictures="aircraft?.pictures" height="250px"/>
        <img v-else class="img-cover" src="@images/no-picture.webp" alt="">

      </template>
      <template v-else>
        <ContentLoader width="470" height="250">
          <rect width="470" height="250" rx="0" ry="0"/>
        </ContentLoader>
      </template>

    </div>
    <div class="card-body">
      <div class="d-flex justify-content-between">
        <div>

          <template v-if="aircraftStateLoaded">
            <h2 class="card-title">

              <template v-if="aircraftState.callsign">

                <RouterLink v-if="flightLoaded && flight" :to="{ name: 'database_flight', params: {
                  flightNumber: flight.flightNumber } }">
                  {{ aircraftState.callsign }}
                </RouterLink>
                <template v-else>
                  {{ aircraftState.callsign }}
                </template>

              </template>
              <template v-else>
                {{ $t('no_callsign') }}
              </template>

            </h2>
          </template>
          <template v-else>
            <ContentLoader class="mb-1" width="100" height="30.63">
              <rect x="0" y="0" width="100" height="24.5" rx="2" ry="2"/>
            </ContentLoader>
          </template>

          <div class="card-subtitle">

            <template v-if="aircraftLoaded">

              <template v-if="aircraft">
                {{ aircraft.manufacturer }} {{ aircraft.model }}
              </template>
              <template v-else>
                {{ $t('unknown_aircraft') }}
              </template>

            </template>
            <template v-else>
              <ContentLoader width="200" height="14"/>
            </template>

          </div>
        </div>

        <div v-if="aircraftLoaded && aircraft?.operator?.logo" class="logo-container">
          <img class="logo" :src="aircraft.operator.logo.url" alt="">
        </div>

      </div>

      <div class="d-flex justify-content-between align-items-center mt-3">
        <FontAwesomeIcon class="me-2" :icon="['far', 'plane-departure']" aria-hidden="true"/>
        <div class="progress" :style="{ width: '100%', height: '5px' }">
          <div class="progress-bar bg-success" role="progressbar" :style="{ width: `${flightProgress}%` }"
               :aria-valuenow="flightProgress" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <FontAwesomeIcon class="ms-2" :icon="['far', 'plane-arrival']" aria-hidden="true"/>
      </div>

      <div class="row mt-3">
        <div class="col-6 text-start">

          <template v-if="flightLoaded">

            <template v-if="flight">
              <RouterLink :to="{ name: 'database_airport', params: { icaoCode: flight.departureAirport.icaoCode } }">
                <h3 class="mb-0">{{ flight.departureAirport.icaoCode }}</h3>
              </RouterLink>
              <div class="text-truncate" data-bs-toggle="tooltip" :title="flight.departureAirport.name">
                {{ flight.departureAirport.name }}
              </div>
              <div class="mt-2">
                <CountryFlag class="me-2" :country-code="flight.departureAirport.country" height="16"/>
                <CountryName :country-code="flight.departureAirport.country"/>
              </div>
            </template>
            <template v-else>
              {{ $t('unknown_departure_airport') }}
            </template>

          </template>
          <template v-else>
            <ContentLoader width="150" height="70.65">
              <rect x="0" y="0" width="50" height="21" rx="2" ry="2"/>
              <rect x="0" y="26.25" width="150" height="14" rx="2" ry="2"/>
              <rect x="0" y="52.45" width="24" height="16" rx="2" ry="2"/>
              <rect x="32" y="53.45" width="100" height="14" rx="2" ry="2"/>
            </ContentLoader>
          </template>

        </div>
        <div class="col-6 text-end">

          <template v-if="flightLoaded">

            <template v-if="flight">
              <RouterLink :to="{ name: 'database_airport', params: { icaoCode: flight.arrivalAirport.icaoCode } }">
                <h3 class="mb-0">{{ flight.arrivalAirport.icaoCode }}</h3>
              </RouterLink>
              <div class="text-truncate" data-bs-toggle="tooltip" :title="flight.arrivalAirport.name">
                {{ flight.arrivalAirport.name }}
              </div>
              <div class="mt-2">
                <CountryName :country-code="flight.arrivalAirport.country"/>
                <CountryFlag class="ms-2" :country-code="flight.arrivalAirport.country" height="16"/>
              </div>
            </template>
            <template v-else>
              {{ $t('unknown_arrival_airport') }}
            </template>

          </template>
          <template v-else>
            <ContentLoader width="150" height="70.65">
              <rect x="0" y="0" width="50" height="21" rx="2" ry="2"/>
              <rect x="0" y="26.25" width="150" height="14" rx="2" ry="2"/>
              <rect x="108" y="52.45" width="24" height="16" rx="2" ry="2"/>
              <rect x="0" y="53.45" width="100" height="14" rx="2" ry="2"/>
            </ContentLoader>
          </template>

        </div>
      </div>

      <div class="table-responsive mt-3">
        <table class="table table-sm mb-0">
          <tbody>
            <tr>
              <th scope="row" class="col-6">
                {{ $t('altitude') }}
                <span class="d-inline-flex ms-1 small" data-bs-toggle="tooltip"
                      :title="$t('distance_of_the_aircraft_to_the_mean_sea_level')">
                  <FontAwesomeIcon :icon="['far', 'circle-question']" aria-hidden="true"/>
                  <span class="visually-hidden">{{ $t('help') }}</span>
                </span>
              </th>
              <td class="col-6">

                <template v-if="aircraftStateLoaded">
                  {{ $n($m.round($m.unit(aircraftState.altitude, 'm').toNumber('ft'))) }}&nbsp;ft /
                  {{ $n($m.round(aircraftState.altitude)) }}&nbsp;m
                </template>
                <template v-else>
                  <ContentLoader width="100" height="14"/>
                </template>

              </td>
            </tr>
            <tr>
              <th scope="row" class="col-6">
                {{ $t('height') }}
                <span class="d-inline-flex ms-1 small" data-bs-toggle="tooltip"
                      :title="$t('distance_of_the_aircraft_to_the_ground_level')">
                  <FontAwesomeIcon :icon="['far', 'circle-question']" aria-hidden="true"/>
                  <span class="visually-hidden">{{ $t('help') }}</span>
                </span>
              </th>
              <td class="col-6">

                <template v-if="aircraftStateLoaded">
                  {{ $n($m.round($m.unit(aircraftState.elevation, 'm').toNumber('ft'))) }}&nbsp;ft /
                  {{ $n($m.round(aircraftState.elevation)) }}&nbsp;m
                </template>
                <template v-else>
                  <ContentLoader width="100" height="14"/>
                </template>

              </td>
            </tr>
            <tr>
              <th scope="row" class="col-6">
                {{ $t('ground_speed') }}
                <span class="d-inline-flex ms-1 small" data-bs-toggle="tooltip"
                      :title="$t('speed_of_the_aircraft_relative_to_a_fixed_point_on_the_ground')">
                  <FontAwesomeIcon :icon="['far', 'circle-question']" aria-hidden="true"/>
                  <span class="visually-hidden">{{ $t('help') }}</span>
                </span>
              </th>
              <td class="col-6">

                <template v-if="aircraftStateLoaded">
                  {{ $n($m.round($m.unit(aircraftState.groundSpeed, 'm/s').toNumber('kt'))) }}&nbsp;kt /
                  {{ $n($m.round($m.unit(aircraftState.groundSpeed, 'm/s').toNumber('km/h'))) }}&nbsp;km/h
                </template>
                <template v-else>
                  <ContentLoader width="100" height="14"/>
                </template>

              </td>
            </tr>
            <tr>
              <th scope="row" class="col-6">{{ $t('vertical_speed') }}</th>
              <td class="col-6">

                <template v-if="aircraftStateLoaded">
                  {{ $n($m.round($m.unit(aircraftState.verticalSpeed, 'm/s').toNumber('fpm'))) }}&nbsp;fpm /
                  {{ $n($m.round(aircraftState.verticalSpeed)) }}&nbsp;m/s
                </template>
                <template v-else>
                  <ContentLoader width="100" height="14"/>
                </template>

              </td>
            </tr>
            <tr>
              <th scope="row" class="col-6">{{ $t('latitude') }}</th>
              <td class="col-6">

                <template v-if="aircraftStateLoaded">
                  {{ $n($m.round(aircraftState.latitude, 5)) }}° /
                  {{ $dms(aircraftState.latitude) }}
                  {{ aircraftState.latitude >= 0 ? 'N' : 'S' }}
                </template>
                <template v-else>
                  <ContentLoader width="150" height="14"/>
                </template>

              </td>
            </tr>
            <tr>
              <th scope="row" class="col-6">{{ $t('longitude') }}</th>
              <td class="col-6">

                <template v-if="aircraftStateLoaded">
                  {{ $n($m.round(aircraftState.longitude, 5)) }}° /
                  {{ $dms(aircraftState.longitude) }}
                  {{ aircraftState.longitude >= 0 ? 'E' : 'W' }}
                </template>
                <template v-else>
                  <ContentLoader width="100" height="14"/>
                </template>

              </td>
            </tr>
            <tr>
              <th scope="row" class="col-6">{{ $t('track') }}</th>
              <td class="col-6">

                <template v-if="aircraftStateLoaded">
                  {{ $n($m.round(aircraftState.track)) }}°
                </template>
                <template v-else>
                  <ContentLoader width="50" height="14"/>
                </template>

              </td>
            </tr>
            <tr>
              <th scope="row" class="col-6">{{ $t('squawk') }}</th>
              <td class="col-6">

                <template v-if="aircraftStateLoaded">
                  {{ aircraftState.squawk || '-' }}
                </template>
                <template v-else>
                  <ContentLoader width="50" height="14"/>
                </template>

              </td>
            </tr>
            <tr>
              <th scope="row" class="col-6">{{ $t('icao_24_bit_address') }}</th>
              <td class="col-6">

                <template v-if="aircraftLoaded">

                  <RouterLink v-if="aircraft" :to="{ name: 'database_aircraft', params: {
                    icao24bitAddress: aircraft.icao24bitAddress } }">
                    {{ aircraft.icao24bitAddress }}
                  </RouterLink>
                  <template v-else>
                    {{ selection.value.aircraft.icao24bitAddress }}
                  </template>

                </template>
                <template v-else>
                  <ContentLoader width="100" height="14"/>
                </template>

              </td>
            </tr>
            <tr>
              <th scope="row" class="col-6">{{ $t('source') }}</th>
              <td class="col-6">

                <template v-if="aircraftStateLoaded">

                  <template v-if="aircraftState.source === 0">
                    <abbr data-bs-toggle="tooltip" :title="$t('automatic_dependent_surveillance_broadcast')">
                      {{ $t('ads_b') }}
                    </abbr>
                  </template>
                  <template v-else-if="aircraftState.source === 1">
                    {{ $t('asterix') }}
                  </template>
                  <template v-else-if="aircraftState.source === 2">
                    <abbr data-bs-toggle="tooltip" :title="$t('multilateration')">
                      {{ $t('mlat') }}
                    </abbr>
                  </template>
                  <template v-else>
                    {{ $t('unknown__f') }}
                  </template>

                </template>
                <template v-else>
                  <ContentLoader width="50" height="14"/>
                </template>

              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <h3 class="mt-3">{{ $t('aircraft__s') }}</h3>
      <div v-if="!aircraftLoaded || aircraft" class="table-responsive">
        <table class="table table-sm mb-0">
          <tbody>
            <tr>
              <th scope="row" class="col-6">{{ $t('aircraft_type') }}</th>
              <td class="col-6">

                <template v-if="aircraftLoaded">

                  <RouterLink v-if="aircraft.aircraftType" :to="{ name: 'database_aircraft_type', params: {
                  icaoCode: aircraft.aircraftType.icaoCode } }">
                    {{ aircraft.aircraftType.manufacturer }} {{ aircraft.aircraftType.name }}
                  </RouterLink>
                  <template v-else>
                    -
                  </template>

                </template>
                <template v-else>
                  <ContentLoader width="200" height="14"/>
                </template>

              </td>
            </tr>
            <tr>
              <th scope="row" class="col-6">{{ $t('manufacturer') }}</th>
              <td class="col-6">

                <template v-if="aircraftLoaded">
                  {{ aircraft.manufacturer }}
                </template>
                <template v-else>
                  <ContentLoader width="100" height="14"/>
                </template>

              </td>
            </tr>
            <tr>
              <th scope="row" class="col-6">{{ $t('model') }}</th>
              <td class="col-6">

                <template v-if="aircraftLoaded">
                  {{ aircraft.model }}
                </template>
                <template v-else>
                  <ContentLoader width="100" height="14"/>
                </template>

              </td>
            </tr>
            <tr>
              <th scope="row" class="col-6">{{ $t('manufactured__m') }}</th>
              <td class="col-6">

                <template v-if="aircraftLoaded">

                  <template v-if="aircraft.manufactured">
                    {{ $dt.fromISO(aircraft.manufactured).setLocale($i18n.locale).toLocaleString($dt.DATE_MED) }}
                    ({{ $dt.fromISO(aircraft.manufactured).setLocale($i18n.locale).toRelative() }})
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
            <tr>
              <th scope="row" class="col-6">
                <abbr data-bs-toggle="tooltip" :title="$t('manufacturer_serial_number')">
                  {{ $t('msn') }}
                </abbr>
              </th>
              <td class="col-6">

                <template v-if="aircraftLoaded">
                  {{ aircraft.serialNumber }}
                </template>
                <template v-else>
                  <ContentLoader width="50" height="14"/>
                </template>

              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <template v-else>
        <NoDataAvailable/>
      </template>

      <h3 class="mt-3">{{ $t('registration') }}</h3>
      <div v-if="!aircraftLoaded || aircraft" class="table-responsive">
        <table class="table table-sm mb-0">
          <tbody>
            <tr>
              <th scope="row" class="col-6">{{ $t('registration') }}</th>
              <td class="col-6">

                <RouterLink v-if="aircraftLoaded" :to="{ name: 'database_aircraft', params: {
                  icao24bitAddress: aircraft.icao24bitAddress } }">
                  {{ aircraft.registration }}
                </RouterLink>
                <template v-else>
                  <ContentLoader width="50" height="14"/>
                </template>

              </td>
            </tr>
            <tr>
              <th scope="row" class="col-6">{{ $t('registration_country') }}</th>
              <td class="col-6">

                <template v-if="aircraftLoaded">

                  <template v-if="aircraft.registrationCountry">
                    <CountryFlag class="me-2" :country-code="aircraft.registrationCountry" height="16"/>
                    <CountryName :country-code="aircraft.registrationCountry"/>
                  </template>
                  <template v-else>
                    -
                  </template>

                </template>
                <template v-else>
                  <ContentLoader width="132" height="16">
                    <rect x="0" y="0" width="24" height="16" rx="2" ry="2"/>
                    <rect x="32" y="1.4375" width="100" height="13.125" rx="2" ry="2"/>
                  </ContentLoader>
                </template>

              </td>
            </tr>
            <tr>
              <th scope="row" class="col-6">{{ $t('registered__m') }}</th>
              <td class="col-6">

                <template v-if="aircraftLoaded">

                  <template v-if="aircraft.registered">
                    {{ $dt.fromISO(aircraft.registered).setLocale($i18n.locale).toLocaleString($dt.DATE_MED) }}
                    ({{ $dt.fromISO(aircraft.registered).setLocale($i18n.locale).toRelative() }})
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
            <tr>
              <th scope="row" class="col-6">{{ $t('registered_until__m') }}</th>
              <td class="col-6">

                <template v-if="aircraftLoaded">

                  <template v-if="aircraft.registeredUntil">
                    {{ $dt.fromISO(aircraft.registeredUntil).setLocale($i18n.locale).toLocaleString($dt.DATE_MED) }}
                    ({{ $dt.fromISO(aircraft.registeredUntil).setLocale($i18n.locale).toRelative() }})
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

      <template v-else>
        <NoDataAvailable/>
      </template>

      <h3 class="mt-3">{{ $t('flight') }}</h3>
      <div class="table-responsive">
        <table class="table table-sm mb-0">
          <tbody>
            <tr>
              <th scope="row" class="col-6">{{ $t('airline') }}</th>
              <td class="col-6">

                <template v-if="flightLoaded">

                  <RouterLink v-if="flight?.airline" :to="{ name: 'database_airline', params: {
                    icaoCode: flight.airline.icaoCode } }">
                    {{ flight.airline.name }}
                  </RouterLink>
                  <template v-else>
                    -
                  </template>

                </template>
                <template v-else>
                  <ContentLoader width="100" height="14"/>
                </template>

              </td>
            </tr>
            <tr>
              <th scope="row" class="col-6">{{ $t('operator') }}</th>
              <td class="col-6">

                <template v-if="aircraftLoaded">

                  <RouterLink v-if="aircraft?.operator" :to="{ name: 'database_airline', params: {
                    icaoCode: aircraft.operator.icaoCode } }">
                    {{ aircraft.operator.name }}
                  </RouterLink>
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
    </div>
  </div>
</template>

<script>
import Carousel from '@scripts/components/Carousel'
import ContentLoader from '@scripts/components/ContentLoader'
import CountryFlag from '@scripts/components/CountryFlag'
import CountryName from '@scripts/components/CountryName'
import NoDataAvailable from '@scripts/components/NoDataAvailable'
import FontAwesomeIcon from '@scripts/fontawesome'
import Math from '@scripts/mathjs'
import { Aircraft, Flight, NotFound } from '@scripts/services/api'
import { AircraftState } from '@scripts/services/opensky-network'
import { CancelToken } from 'axios'
import * as Geometry from 'ol/geom'

export default {
  name: 'AircraftDetails',
  components: {
    Carousel,
    ContentLoader,
    CountryFlag,
    CountryName,
    FontAwesomeIcon,
    NoDataAvailable
  },
  inject: ['selection'],
  computed: {
    flightProgress () {
      if (!this.aircraftState || !this.aircraftStateLoaded || !this.flight || !this.flightLoaded) {
        return 0
      }

      const distanceFromDeparture = new Geometry.LineString([
        [this.aircraftState.longitude, this.aircraftState.latitude],
        [this.flight.departureAirport.longitude, this.flight.departureAirport.latitude]
      ]).getLength()
      const distanceToArrival = new Geometry.LineString([
        [this.aircraftState.longitude, this.aircraftState.latitude],
        [this.flight.arrivalAirport.longitude, this.flight.arrivalAirport.latitude]
      ]).getLength()

      return Math.ceil((distanceFromDeparture * 100) / (distanceFromDeparture + distanceToArrival))
    }
  },
  methods: {
    loadAircraft () {
      this.aircraftCancelToken?.cancel('Concurrent request')
      this.aircraftCancelToken = CancelToken.source()
      this.aircraftLoaded = false

      Aircraft.getAircraft(this.selection.value.aircraft, {
        cancelToken: this.aircraftCancelToken.token
      }).then(aircraft => {
        this.aircraft = aircraft
        this.aircraftLoaded = true
      }).catch(error => {
        if (error instanceof NotFound) {
          this.aircraft = null
          this.aircraftLoaded = true
          return
        }

        throw error
      })
    },
    loadAircraftState () {
      this.aircraftStateCancelToken?.cancel('Concurrent request')
      this.aircraftStateCancelToken = CancelToken.source()
      this.aircraftStateLoaded = false

      AircraftState.getAircraftState(this.selection.value.aircraft, {
        cancelToken: this.aircraftStateCancelToken.token
      }).then(aircraftState => {
        this.aircraftState = aircraftState
        this.aircraftStateLoaded = true
      }).catch(error => {
        if (error instanceof NotFound) {
          return
        }

        throw error
      })

      this.aircraftStateRefreshInterval = window.setInterval(this.refreshAircraftState, 5000)
    },
    loadFlight () {
      this.flightCancelToken?.cancel('Concurrent request')
      this.flightCancelToken = CancelToken.source()
      this.flightLoaded = false

      if (!this.selection.value.flight) {
        this.flight = null
        this.flightLoaded = true
        return
      }

      Flight.getFlight(this.selection.value.flight, {
        cancelToken: this.flightCancelToken?.token
      }).then(flight => {
        this.flight = flight
        this.flightLoaded = true
      }).catch(error => {
        if (error instanceof NotFound) {
          this.flight = null
          this.flightLoaded = true
          return
        }

        throw error
      })
    },
    refreshAircraftState () {
      this.aircraftStateCancelToken?.cancel('Concurrent request')
      this.aircraftStateCancelToken = CancelToken.source()

      AircraftState.getAircraftState(this.selection.value.aircraft, {
        cancelToken: this.aircraftStateCancelToken.token
      }).then(aircraftState => {
        this.aircraftState = aircraftState
        this.aircraftStateLoaded = true
      }).catch(error => {
        if (error instanceof NotFound) {
          return
        }

        throw error
      })
    }
  },
  watch: {
    selection: {
      deep: true,
      handler (selection) {
        clearInterval(this.aircraftStateRefreshInterval)

        if (selection.value?.aircraft) {
          this.loadAircraft()
          this.loadAircraftState()
        }

        if (selection.value?.flight) {
          this.loadFlight()
        }
      }
    }
  },
  data () {
    return {
      aircraft: null,
      aircraftCancelToken: null,
      aircraftLoaded: false,
      aircraftState: null,
      aircraftStateCancelToken: null,
      aircraftStateLoaded: false,
      aircraftStateRefreshInterval: null,
      flight: null,
      flightCancelToken: null,
      flightLoaded: false
    }
  },
  unmounted () {
    clearInterval(this.aircraftStateRefreshInterval)
    this.aircraftCancelToken?.cancel('Component unmounted')
    this.aircraftStateCancelToken?.cancel('Component unmounted')
    this.flightCancelToken?.cancel('Component unmounted')
  }
}
</script>
