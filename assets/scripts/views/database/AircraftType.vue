<template>
  <DefaultLayout>
    <template #content>
      <div class="row g-3">
        <div class="col-12 col-xl-8">
          <div class="card h-100 overflow-hidden">
            <div class="carousel-container">

              <template v-if="aircraftTypeLoaded">
                <Carousel v-if="aircraftType.pictures.length" :pictures="aircraftType.pictures" height="800px"/>
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

            <template v-if="aircraftTypeLoaded">
              <h1>{{ aircraftType.manufacturer }} {{ aircraftType.name }}</h1>
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

                      <template v-if="aircraftTypeLoaded">
                        {{ aircraftType.icaoCode }}
                      </template>
                      <template v-else>
                        <ContentLoader width="100" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('iata_code') }}</th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">
                        {{ aircraftType.iataCode || '-' }}
                      </template>
                      <template v-else>
                        <ContentLoader width="100" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('aircraft_family') }}</th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.aircraftFamily === 'A'">
                          {{ $t('amphibious_plane') }}
                        </template>
                        <template v-else-if="aircraftType.aircraftFamily === 'G'">
                          {{ $t('autogyro') }}
                        </template>
                        <template v-else-if="aircraftType.aircraftFamily === 'H'">
                          {{ $t('helicopter') }}
                        </template>
                        <template v-else-if="aircraftType.aircraftFamily === 'L'">
                          {{ $t('airplane') }}
                        </template>
                        <template v-else-if="aircraftType.aircraftFamily === 'T'">
                          {{ $t('tiltrotor') }}
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
                  <tr>
                    <th scope="row" class="col-6">{{ $t('engine_type') }}</th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.engineType === 'E'">
                          {{ $t('electric') }}
                        </template>
                        <template v-else-if="aircraftType.engineType === 'J'">
                          {{ $t('turbojet') }}
                        </template>
                        <template v-else-if="aircraftType.engineType === 'P'">
                          {{ $t('piston') }}
                        </template>
                        <template v-else-if="aircraftType.engineType === 'T'">
                          {{ $t('turboprop_turboshaft') }}
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
                  <tr>
                    <th scope="row" class="col-6">{{ $t('engine_count') }}</th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.engineCount">
                          {{ aircraftType.engineCount }}
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
                    <th scope="row" class="col-6">{{ $t('icao_wake_turbulence_category') }}</th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.wtc === 'L'">
                          {{ $t('light__m') }}
                        </template>
                        <template v-else-if="aircraftType.wtc === 'M'">
                          {{ $t('medium__m') }}
                        </template>
                        <template v-else-if="aircraftType.wtc === 'H'">
                          {{ $t('heavy__m') }}
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
            <h3>{{ $t('dimensions') }}</h3>
            <div class="table-responsive">
              <table class="table mb-0">
                <tbody>
                  <tr>
                    <th scope="row" class="col-6">
                      {{ $t('length') }}

                      <template v-if="aircraftTypeLoaded && aircraftType.aircraftFamily?.match(/^[GH]$/)">
                        <span class="d-inline-flex ms-1 small" data-bs-toggle="tooltip"
                              :title="$t('rotors_excluded')">
                          <FontAwesomeIcon :icon="['far', 'circle-question']" aria-hidden="true"/>
                          <span class="visually-hidden">{{ $t('help') }}</span>
                        </span>
                      </template>

                    </th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.length">
                          {{ $n($m.round(aircraftType.length, 2)) }}&nbsp;m /
                          {{ $n($m.round($m.unit(aircraftType.length, 'm').toNumber('ft'), 2)) }}&nbsp;ft
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
                  <tr>
                    <th scope="row" class="col-6">{{ $t('height') }}</th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.height">
                          {{ $n($m.round(aircraftType.height, 2)) }}&nbsp;m /
                          {{ $n($m.round($m.unit(aircraftType.height, 'm').toNumber('ft'), 2)) }}&nbsp;ft
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

                  <template v-if="aircraftTypeLoaded">

                    <template v-if="aircraftType.aircraftFamily?.match(/^[ALT]$/)">
                      <tr>
                        <th scope="row" class="col-6">{{ $t('wingspan') }}</th>
                        <td class="col-6">

                          <template v-if="aircraftType.wingspan">
                            {{ $n($m.round(aircraftType.wingspan, 2)) }}&nbsp;m /
                            {{ $n($m.round($m.unit(aircraftType.wingspan, 'm').toNumber('ft'), 2)) }}&nbsp;ft
                          </template>
                          <template v-else>
                            -
                          </template>

                        </td>
                      </tr>
                      <tr>
                        <th scope="row" class="col-6">{{ $t('wing_area') }}</th>
                        <td class="col-6">

                          <template v-if="aircraftType.wingArea">
                            {{ $n($m.round(aircraftType.wingArea, 2)) }}&nbsp;m² /
                            {{ $n($m.round($m.unit(aircraftType.wingArea, 'm2').toNumber('sqft'), 2)) }}&nbsp;sq ft
                          </template>
                          <template v-else>
                            -
                          </template>

                        </td>
                      </tr>
                    </template>

                    <template v-if="aircraftType.aircraftFamily?.match(/^[GHT]$/)">
                      <tr>
                        <th scope="row" class="col-6">{{ $t('main_rotor_diameter') }}</th>
                        <td class="col-6">

                          <template v-if="aircraftType.mainRotorDiameter">
                            {{ $n($m.round(aircraftType.mainRotorDiameter, 2)) }}&nbsp;m /
                            {{ $n($m.round($m.unit(aircraftType.mainRotorDiameter, 'm').toNumber('ft'), 2)) }}&nbsp;ft
                          </template>
                          <template v-else>
                            -
                          </template>

                        </td>
                      </tr>
                      <tr>
                        <th scope="row" class="col-6">{{ $t('main_rotor_area') }}</th>
                        <td class="col-6">

                          <template v-if="aircraftType.mainRotorArea">
                            {{ $n($m.round(aircraftType.mainRotorArea, 2)) }}&nbsp;m² /
                            {{ $n($m.round($m.unit(aircraftType.mainRotorArea, 'm2').toNumber('sqft'), 2)) }}&nbsp;sq ft
                          </template>
                          <template v-else>
                            -
                          </template>

                        </td>
                      </tr>
                    </template>

                  </template>
                  <template v-else>
                    <tr v-for="index in $m.range(0, 2).toArray()" :key="index">
                      <td>
                        <ContentLoader width="50" height="15"/>
                      </td>
                      <td>
                        <ContentLoader width="50" height="15"/>
                      </td>
                    </tr>
                  </template>

                  <tr>
                    <th scope="row" class="col-6">{{ $t('fuselage_height') }}</th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.fuselageHeight">
                          {{ $n($m.round(aircraftType.fuselageHeight, 2)) }}&nbsp;m /
                          {{ $n($m.round($m.unit(aircraftType.fuselageHeight, 'm').toNumber('ft'), 2)) }}&nbsp;ft
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
                  <tr>
                    <th scope="row" class="col-6">{{ $t('fuselage_width') }}</th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.fuselageWidth">
                          {{ $n($m.round(aircraftType.fuselageWidth, 2)) }}&nbsp;m /
                          {{ $n($m.round($m.unit(aircraftType.fuselageWidth, 'm').toNumber('ft'), 2)) }}&nbsp;ft
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
            <h3>{{ $t('weight') }}</h3>
            <div class="table-responsive">
              <table class="table mb-0">
                <tbody>
                  <tr>
                    <th scope="row" class="col-6">
                      <abbr data-bs-toggle="tooltip" :title="$t('operating_empty_weight')">
                        {{ $t('oew') }}
                      </abbr>
                    </th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.oew">
                          {{ $n($m.round(aircraftType.oew)) }}&nbsp;kg /
                          {{ $n($m.round($m.unit(aircraftType.oew, 'kg').toNumber('lb'))) }}&nbsp;lb
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
                  <tr>
                    <th scope="row" class="col-6">
                      <abbr data-bs-toggle="tooltip" :title="$t('all_up_weight')">
                        {{ $t('auw') }}
                      </abbr>
                    </th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.auw">
                          {{ $n($m.round(aircraftType.auw)) }}&nbsp;kg /
                          {{ $n($m.round($m.unit(aircraftType.auw, 'kg').toNumber('lb'))) }}&nbsp;lb
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
                  <tr>
                    <th scope="row" class="col-6">
                      <abbr data-bs-toggle="tooltip" :title="$t('maximum_zero_fuel_weight')">
                        {{ $t('mzfw') }}
                      </abbr>
                    </th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.mzfw">
                          {{ $n($m.round(aircraftType.mzfw)) }}&nbsp;kg /
                          {{ $n($m.round($m.unit(aircraftType.mzfw, 'kg').toNumber('lb'))) }}&nbsp;lb
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
                  <tr>
                    <th scope="row" class="col-6">
                      <abbr data-bs-toggle="tooltip" :title="$t('maximum_ramp_weight')">
                        {{ $t('mrw') }}
                      </abbr> /
                      <abbr data-bs-toggle="tooltip" :title="$t('maximum_taxi_weight')">
                        {{ $t('mtw') }}
                      </abbr>
                    </th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.mrw">
                          {{ $n($m.round(aircraftType.mrw)) }}&nbsp;kg /
                          {{ $n($m.round($m.unit(aircraftType.mrw, 'kg').toNumber('lb'))) }}&nbsp;lb
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
                  <tr>
                    <th scope="row" class="col-6">
                      <abbr data-bs-toggle="tooltip" :title="$t('maximum_take_off_weight')">
                        {{ $t('mtow') }}
                      </abbr>
                    </th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.mtow">
                          {{ $n($m.round(aircraftType.mtow)) }}&nbsp;kg /
                          {{ $n($m.round($m.unit(aircraftType.mtow, 'kg').toNumber('lb'))) }}&nbsp;lb
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
                  <tr>
                    <th scope="row" class="col-6">
                      <abbr data-bs-toggle="tooltip" :title="$t('maximum_landing_weight')">
                        {{ $t('mlw') }}
                      </abbr>
                    </th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.mlw">
                          {{ $n($m.round(aircraftType.mlw)) }}&nbsp;kg /
                          {{ $n($m.round($m.unit(aircraftType.mlw, 'kg').toNumber('lb'))) }}&nbsp;lb
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
        </div>
        <div class="col-12 col-xl-4 d-flex">
          <div class="card card-body h-100">
            <h3>{{ $t('performance') }}</h3>
            <div class="table-responsive">
              <table class="table mb-0">
                <tbody>
                  <tr>
                    <th scope="row" class="col-6">
                      {{ $t('operating_range') }}
                      <span class="d-inline-flex ms-1 small" data-bs-toggle="tooltip"
                            :title="$t('standard_operating_conditions_with_maximum_internal_fuel')">
                        <FontAwesomeIcon :icon="['far', 'circle-question']" aria-hidden="true"/>
                        <span class="visually-hidden">{{ $t('help') }}</span>
                      </span>
                    </th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.operatingRange">
                          {{ $n($m.round(aircraftType.operatingRange)) }}&nbsp;nm /
                          {{ $n($m.round($m.unit(aircraftType.operatingRange, 'nmi').toNumber('km'))) }}&nbsp;km /
                          {{ $n($m.round($m.unit(aircraftType.operatingRange, 'nmi').toNumber('mi'))) }}&nbsp;mi
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
                    <th scope="row" class="col-6">
                      {{ $t('ferry_range') }}
                      <span class="d-inline-flex ms-1 small" data-bs-toggle="tooltip"
                            :title="$t('no_payload_with_maximum_internal_fuel_and_external_fuel_tanks_if_applicable')">
                        <FontAwesomeIcon :icon="['far', 'circle-question']" aria-hidden="true"/>
                        <span class="visually-hidden">{{ $t('help') }}</span>
                      </span>
                    </th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.ferryRange">
                          {{ $n($m.round(aircraftType.ferryRange)) }}&nbsp;nm /
                          {{ $n($m.round($m.unit(aircraftType.ferryRange, 'nmi').toNumber('km'))) }}&nbsp;km /
                          {{ $n($m.round($m.unit(aircraftType.ferryRange, 'nmi').toNumber('mi'))) }}&nbsp;mi
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
                    <th scope="row" class="col-6">{{ $t('climb_rate') }}</th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.climbRate">
                          {{ $n($m.round(aircraftType.climbRate)) }}&nbsp;fpm /
                          {{ $n($m.round($m.unit(aircraftType.climbRate, 'fpm').toNumber('m/s'))) }}&nbsp;m/s
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
        </div>
        <div class="col-12 col-xl-4 d-flex">
          <div class="card card-body h-100">
            <h3>{{ $t('fuel_capacity') }}</h3>
            <div class="table-responsive">
              <table class="table mb-0">
                <tbody>
                  <tr>
                    <th scope="row" class="col-6">
                      {{ $t('fuel_capacity') }}
                      <span class="d-inline-flex ms-1 small" data-bs-toggle="tooltip"
                            :title="$t('internal_fuel_only')">
                        <FontAwesomeIcon :icon="['far', 'circle-question']" aria-hidden="true"/>
                        <span class="visually-hidden">{{ $t('help') }}</span>
                      </span>
                    </th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.fuelCapacity">
                          {{ $n($m.round(aircraftType.fuelCapacity)) }}&nbsp;l /
                          ≈ {{ $n($m.round(aircraftType.fuelCapacity * 0.8)) }}&nbsp;kg /
                          ≈ {{ $n($m.round(aircraftType.fuelCapacity * 1.76)) }}&nbsp;lbs
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
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-4 d-flex">
          <div class="card card-body h-100">
            <h3>{{ $t('speed') }}</h3>
            <div class="table-responsive">
              <table class="table mb-0">
                <tbody>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('approach_speed') }} (V<sub>ref</sub>)</th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.approachSpeed">
                          {{ $n($m.round(aircraftType.approachSpeed)) }}&nbsp;kt /
                          {{ $n($m.round($m.unit(aircraftType.approachSpeed, 'kt').toNumber('km/h'))) }}&nbsp;km/h /
                          {{ $n($m.round($m.unit(aircraftType.approachSpeed, 'kt').toNumber('mi/h'))) }}&nbsp;mph
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
                    <th scope="row" class="col-6">{{ $t('cruise_speed') }} (V<sub>no</sub>)</th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.cruiseSpeed">
                          {{ $n($m.round(aircraftType.cruiseSpeed)) }}&nbsp;kt /
                          {{ $n($m.round($m.unit(aircraftType.cruiseSpeed, 'kt').toNumber('km/h'))) }}&nbsp;km/h /
                          {{ $n($m.round($m.unit(aircraftType.cruiseSpeed, 'kt').toNumber('mi/h'))) }}&nbsp;mph
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
                    <th scope="row" class="col-6">{{ $t('maximum_speed') }} (V<sub>mo</sub>)</th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.maximumSpeed">
                          {{ $n($m.round(aircraftType.maximumSpeed)) }}&nbsp;kt /
                          {{ $n($m.round($m.unit(aircraftType.maximumSpeed, 'kt').toNumber('km/h'))) }}&nbsp;km/h /
                          {{ $n($m.round($m.unit(aircraftType.maximumSpeed, 'kt').toNumber('mi/h'))) }}&nbsp;mph
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
                    <th scope="row" class="col-6">{{ $t('never_exceed_speed') }} (V<sub>ne</sub>)</th>
                    <td class="col-6">

                      <template v-if="aircraftTypeLoaded">

                        <template v-if="aircraftType.neverExceedSpeed">
                          {{ $n($m.round(aircraftType.neverExceedSpeed)) }}&nbsp;kt /
                          {{ $n($m.round($m.unit(aircraftType.neverExceedSpeed, 'kt').toNumber('km/h'))) }}&nbsp;km/h /
                          {{ $n($m.round($m.unit(aircraftType.neverExceedSpeed, 'kt').toNumber('mi/h'))) }}&nbsp;mph
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
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-12">
          <AircraftTypeModels :aircraft-type="icaoCode"/>
          <AircraftTypeFleet :aircraft-type="icaoCode" class="mt-3"/>
        </div>
      </div>
    </template>
  </DefaultLayout>
</template>

<script>
import Carousel from '@scripts/components/Carousel'
import ContentLoader from '@scripts/components/ContentLoader'
import AircraftTypeFleet from '@scripts/components/database/AircraftTypeFleet'
import AircraftTypeModels from '@scripts/components/database/AircraftTypeModels'
import FontAwesomeIcon from '@scripts/fontawesome'
import DefaultLayout from '@scripts/layouts/DefaultLayout'
import { AircraftType } from '@scripts/services/api'
import { CancelToken } from 'axios'
import { mapActions } from 'vuex'

export default {
  name: 'AircraftType',
  components: {
    AircraftTypeFleet,
    AircraftTypeModels,
    Carousel,
    ContentLoader,
    DefaultLayout,
    FontAwesomeIcon
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
    loadAircraftType () {
      this.cancelToken = CancelToken.source()

      AircraftType.getAircraftType(this.icaoCode, {
        cancelToken: this.cancelToken.token
      }).then(aircraftType => {
        this.aircraftType = aircraftType
        this.aircraftTypeLoaded = true
      }).catch(error => {
        if (error.response?.status === 404) {
          this.$router.replace({ name: 'not_found' })
        }

        throw error
      })
    }
  },
  watch: {
    '$i18n.locale' () {
      if (this.aircraftTypeLoaded) {
        const { iataCode, icaoCode, manufacturer, name } = this.aircraftType
        this.setMetaDescription(this.$t('meta_description.aircraft_type', {
          iataCode: iataCode || '-',
          icaoCode,
          manufacturer,
          name
        }))
      }
    },
    aircraftType: {
      deep: true,
      handler (aircraftType) {
        const { iataCode = '-', icaoCode, manufacturer, name } = aircraftType
        this.setMetaDescription(this.$t('meta_description.aircraft_type', {
          iataCode: iataCode || '-',
          icaoCode,
          manufacturer,
          name
        }))
        this.setMetaImages(aircraftType.pictures)
        this.setMetaTitle(`${manufacturer} ${name} - ${icaoCode}/${iataCode || '-'}`)
        this.setPageTitle(`${manufacturer} ${name} - ${icaoCode}/${iataCode || '-'}`)
      }
    }
  },
  data () {
    return {
      aircraftType: null,
      aircraftTypeLoaded: false,
      cancelToken: null
    }
  },
  mounted () {
    this.setMetaRobots('index,follow,noarchive')
    this.setMetaUrl(this.$route.path)
    this.loadAircraftType()
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
