<template>
  <DefaultLayout>
    <template #content>
      <div class="row g-3">
        <div class="col-xl-8">
          <div class="card h-100 overflow-hidden">
            <div class="carousel-container">

              <template v-if="aircraftLoaded">
                <Carousel v-if="aircraft.pictures.length" :pictures="aircraft.pictures" height="800px"/>
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
              <template v-if="aircraftLoaded">
                <h1>{{ aircraft.registration }}</h1>
              </template>
              <template v-else>
                <ContentLoader class="mb-3" width="100" height="37.5"/>
              </template>

              <div v-if="aircraftLoaded && aircraft.operator?.logo" class="logo-container">
                <img class="logo" :src="aircraft.operator.logo.url" alt="">
              </div>

            </div>
            <div class="table-responsive">
              <table class="table mb-0">
                <tbody>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('aircraft_family') }}</th>
                    <td class="col-6">

                      <template v-if="aircraftLoaded">

                        <template v-if="aircraft.aircraftFamily === 'A'">
                          {{ $t('amphibious_plane') }}
                        </template>
                        <template v-else-if="aircraft.aircraftFamily === 'G'">
                          {{ $t('autogyro') }}
                        </template>
                        <template v-else-if="aircraft.aircraftFamily === 'H'">
                          {{ $t('helicopter') }}
                        </template>
                        <template v-else-if="aircraft.aircraftFamily === 'L'">
                          {{ $t('airplane') }}
                        </template>
                        <template v-else-if="aircraft.aircraftFamily === 'T'">
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

                      <template v-if="aircraftLoaded">

                        <template v-if="aircraft.engineType === 'E'">
                          {{ $t('electric') }}
                        </template>
                        <template v-else-if="aircraft.engineType === 'J'">
                          {{ $t('turbojet') }}
                        </template>
                        <template v-else-if="aircraft.engineType === 'P'">
                          {{ $t('piston') }}
                        </template>
                        <template v-else-if="aircraft.engineType === 'T'">
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

                      <template v-if="aircraftLoaded">

                        <template v-if="aircraft.engineCount">
                          {{ aircraft.engineCount }}
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
                        <ContentLoader width="200" height="15"/>
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
                          {{ $dt.fromISO(aircraft.manufactured).toLocaleString($dt.DATE_MED) }}
                          ({{ $dt.fromISO(aircraft.manufactured).toRelative() }})
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
                      <abbr data-bs-toggle="tooltip" :title="$t('manufacturer_serial_number')">
                        {{ $t('msn') }}
                      </abbr>
                    </th>
                    <td class="col-6">

                      <template v-if="aircraftLoaded">
                        {{ aircraft.serialNumber }}
                      </template>
                      <template v-else>
                        <ContentLoader width="50" height="15"/>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('operator') }}</th>
                    <td class="col-6">

                      <template v-if="aircraftLoaded">

                        <RouterLink v-if="aircraft.operator" :to="{ name: 'database_airline', params: {
                          icaoCode: aircraft.operator.icaoCode } }">
                          {{ aircraft.operator.name }}
                        </RouterLink>
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
                    <th scope="row" class="col-6">{{ $t('icao_24_bit_address') }}</th>
                    <td class="col-6">

                      <template v-if="aircraftLoaded">
                        {{ aircraft.icao24bitAddress }}
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
            <h3>{{ $t('registration') }}</h3>
            <div class="table-responsive">
              <table class="table mb-0">
                <tbody>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('registration') }}</th>
                    <td class="col-6">

                      <template v-if="aircraftLoaded">
                        {{ aircraft.registration }}
                      </template>
                      <template v-else>
                        <ContentLoader width="50" height="15"/>
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
                          <rect x="32" y="0.5" width="100" height="15" rx="2" ry="2"/>
                        </ContentLoader>
                      </template>

                    </td>
                  </tr>
                  <tr>
                    <th scope="row" class="col-6">{{ $t('registered__m') }}</th>
                    <td class="col-6">

                      <template v-if="aircraftLoaded">

                        <template v-if="aircraft.registered">
                          {{ $dt.fromISO(aircraft.registered).toLocaleString($dt.DATE_MED) }}
                          ({{ $dt.fromISO(aircraft.registered).toRelative() }})
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
                    <th scope="row" class="col-6">{{ $t('registered_until__m') }}</th>
                    <td class="col-6">

                      <template v-if="aircraftLoaded">

                        <template v-if="aircraft.registeredUntil">
                          {{ $dt.fromISO(aircraft.registeredUntil).toLocaleString($dt.DATE_MED) }}
                          ({{ $dt.fromISO(aircraft.registeredUntil).toRelative() }})
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
      </div>
    </template>
  </DefaultLayout>
</template>

<script>
import Carousel from '@scripts/components/Carousel'
import ContentLoader from '@scripts/components/ContentLoader'
import CountryFlag from '@scripts/components/CountryFlag'
import CountryName from '@scripts/components/CountryName'
import DefaultLayout from '@scripts/layouts/DefaultLayout'
import { Aircraft, NotFound } from '@scripts/services/api'
import { CancelToken } from 'axios'
import { mapActions } from 'vuex'

export default {
  name: 'Aircraft',
  components: {
    Carousel,
    ContentLoader,
    CountryFlag,
    CountryName,
    DefaultLayout
  },
  props: {
    icao24bitAddress: String
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
    loadAircraft () {
      this.cancelToken = CancelToken.source()

      Aircraft.getAircraft(this.icao24bitAddress, {
        cancelToken: this.cancelToken.token
      }).then(aircraft => {
        this.aircraft = aircraft
        this.aircraftLoaded = true
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
      if (this.aircraftLoaded) {
        const { manufacturer, model, registration, serialNumber } = this.aircraft
        this.setMetaDescription(this.$t('meta_description.aircraft', {
          manufacturer,
          model,
          registration,
          serialNumber
        }))
      }
    },
    aircraft: {
      deep: true,
      handler (aircraft) {
        const { manufacturer, model, registration, serialNumber } = aircraft
        this.setMetaDescription(this.$t('meta_description.aircraft', {
          manufacturer,
          model,
          registration,
          serialNumber
        }))
        this.setMetaImages(aircraft.pictures)
        this.setMetaTitle(`${registration} - ${manufacturer} ${model} - ${serialNumber}`)
        this.setPageTitle(`${registration} - ${manufacturer} ${model} - ${serialNumber}`)
      }
    }
  },
  data () {
    return {
      aircraft: null,
      aircraftLoaded: false,
      cancelToken: null
    }
  },
  mounted () {
    this.setMetaRobots('index,follow,noarchive')
    this.setMetaUrl(this.$route.path)
    this.loadAircraft()
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
