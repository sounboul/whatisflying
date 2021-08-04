<template>
  <DatabaseLayout>

    <template #header>
      <h1 class="card-title">{{ $t('aircraft__p') }}</h1>
      <ListHeader :items="aircrafts" :items-loaded="aircraftsLoaded"/>
    </template>

    <template #filters>
      <div class="row g-3">
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterRegistration">{{ $t('label.registration') }}</label>
          <input class="form-control" id="filterRegistration" type="text"
                 :placeholder="$t('enter_a_registration')" v-model="filters.registration">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterRegistrationCountry">{{ $t('label.registration_country') }}</label>
          <CountrySelect id="filterRegistrationCountry" mode="multiple" v-model="filters.registrationCountry"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterIcao24bitAddress">{{ $t('label.icao_24_bit_address') }}</label>
          <input class="form-control" id="filterIcao24bitAddress" type="text"
                 :placeholder="$t('enter_an_icao_24_bit_address')" v-model="filters.icao24bitAddress">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterAircraftFamily">{{ $t('label.aircraft_family') }}</label>
          <AircraftFamilySelect id="filterAircraftFamily" mode="multiple" v-model="filters.aircraftFamily"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterAircraftType">{{ $t('label.aircraft_type') }}</label>
          <AircraftTypeSelect id="filterAircraftType" mode="multiple" v-model="filters['aircraftType.icaoCode']"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterManufacturer">{{ $t('label.manufacturer') }}</label>
          <input class="form-control" id="filterManufacturer" type="text"
                 :placeholder="$t('enter_a_manufacturer')" v-model="filters.manufacturer">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterModel">{{ $t('label.model') }}</label>
          <input class="form-control" id="filterModel" type="text"
                 :placeholder="$t('enter_a_model')" v-model="filters.model">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterEngineType">{{ $t('label.engine_type') }}</label>
          <EngineTypeSelect id="filterEngineType" mode="multiple" v-model="filters.engineType"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterEngineCount">{{ $t('label.engine_count') }}</label>
          <input class="form-control" id="filterEngineCount" type="number"
                 :placeholder="$t('enter_an_engine_count')" v-model="filters.engineCount"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterSerialNumber">
            <abbr data-bs-toggle="tooltip" :title="$t('manufacturer_serial_number')">{{ $t('label.msn') }}</abbr>
          </label>
          <input class="form-control" id="filterSerialNumber" type="text"
                 :placeholder="$t('enter_a_serial_number')" v-model="filters.serialNumber">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterOperator">{{ $t('label.operator') }}</label>
          <AirlineSelect id="filterOperator" mode="multiple" v-model="filters['operator.icaoCode']"/>
        </div>
      </div>
      <div class="d-flex justify-content-center mt-5">
        <button class="btn btn-outline-primary" type="button" @click="resetFilters">
          {{ $t('reset_filters') }}
        </button>
      </div>
    </template>

    <template #sort>
      <div class="row g-3">
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="orderManufacturer">{{ $t('label.manufacturer') }}</label>
          <OrderSelect id="orderManufacturer" v-model="order.manufacturer"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="orderModel">{{ $t('label.model') }}</label>
          <OrderSelect id="orderModel" v-model="order.model"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="orderRegistration">{{ $t('label.registration') }}</label>
          <OrderSelect id="orderRegistration" v-model="order.registration"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="orderRegistrationCountry">{{ $t('label.registration_country') }}</label>
          <OrderSelect id="orderRegistrationCountry" v-model="order.registrationCountry"/>
        </div>
      </div>
    </template>

    <template #gridView>
      <div v-if="aircraftsLoaded" class="row g-3">
        <div v-for="aircraft in aircrafts['hydra:member']" :key="aircraft.id"
             class="col-md-6 col-lg-4 col-xl-3 d-flex flex-column">
          <div class="card h-100">
            <RouterLink :to="{ name: 'database_aircraft', params: { icao24bitAddress: aircraft.icao24bitAddress } }">
              <div class="card-img-top overflow-hidden" :style="{ height: '250px' }">

                <img v-if="aircraft.firstPicture" class="img-cover" :src="aircraft.firstPicture.url" alt="">
                <img v-else class="img-cover" src="@images/no-picture.webp" alt="">

              </div>
            </RouterLink>
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div class="overflow-hidden">
                  <h4 class="card-title text-truncate">
                    <RouterLink :to="{ name: 'database_aircraft', params: {
                       icao24bitAddress: aircraft.icao24bitAddress } }">
                      {{ aircraft.registration }}
                    </RouterLink>
                  </h4>
                  <div class="card-subtitle text-truncate">
                    {{ aircraft.manufacturer }} {{ aircraft.model }}
                  </div>
                </div>

                <div v-if="aircraft.operator?.logo" class="logo-container">
                  <img class="logo" :src="aircraft.operator.logo.url" alt="">
                </div>

              </div>

              <div v-if="aircraft.registrationCountry" class="mt-3 small text-truncate">
                <CountryFlag class="me-2" :country-code="aircraft.registrationCountry" height="16"/>
                <CountryName :country-code="aircraft.registrationCountry"/>
              </div>

            </div>
          </div>
        </div>
      </div>

      <div v-else class="row g-3">
        <div v-for="index in $m.range(0, 24).toArray()" :key="index"
             class="col-md-6 col-lg-4 col-xl-3 d-flex flex-column">
          <div class="card">
            <div class="card-img-top overflow-hidden" :style="{ height: '250px' }">
              <ContentLoader width="730" height="250">
                <rect x="0" y="0" width="730" height="250"/>
              </ContentLoader>
            </div>
            <div class="card-body">
              <ContentLoader width="730" height="78.46">
                <rect x="0" y="0" width="100" height="18.75" rx="2" ry="2"/>
                <rect x="0" y="25.43" width="200" height="15" rx="2" ry="2"/>
                <rect x="0" y="60.93" width="24" height="16" rx="2" ry="2"/>
                <rect x="32" y="62.3675" width="100" height="13.125" rx="2" ry="2"/>
              </ContentLoader>
            </div>
          </div>
        </div>
      </div>
    </template>

    <template #listView>
      <!-- @bug: Workaround for bug https://github.com/vuejs/vue-next/issues/3569 -->
      <div class="card card-body" :key="1">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead>
              <tr>
                <th scope="col" class="col-1">
                  <ColumnHeader v-model="order.registration">
                    {{ $t('registration') }}
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-1">
                  <ColumnHeader v-model="order.icao24bitAddress">
                    {{ $t('icao_24_bit_address') }}
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-2">
                  <ColumnHeader v-model="order.manufacturer">
                    {{ $t('manufacturer') }}
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-2">
                  <ColumnHeader v-model="order.model">
                    {{ $t('model') }}
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-2">
                  <ColumnHeader v-model="order['aircraftType.name']">
                    {{ $t('aircraft_type') }}
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-1">
                  <ColumnHeader v-model="order.serialNumber">
                    <abbr data-bs-toggle="tooltip" :title="$t('manufacturer_serial_number')">
                      {{ $t('msn') }}
                    </abbr>
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-2">
                  <ColumnHeader v-model="order['operator.name']">
                    {{ $t('operator') }}
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-2">
                  <ColumnHeader v-model="order.registrationCountry">
                    {{ $t('registration_country') }}
                  </ColumnHeader>
                </th>
              </tr>
            </thead>
            <tbody>

              <template v-if="aircraftsLoaded">
                <tr v-for="aircraft in aircrafts['hydra:member']" :key="aircraft.id">
                  <td>
                    <RouterLink :to="{ name: 'database_aircraft', params: {
                      icao24bitAddress: aircraft.icao24bitAddress } }">
                      {{ aircraft.registration }}
                    </RouterLink>
                  </td>
                  <td>{{ aircraft.icao24bitAddress }}</td>
                  <td>{{ aircraft.manufacturer }}</td>
                  <td>{{ aircraft.model }}</td>
                  <td>

                    <RouterLink v-if="aircraft.aircraftType" :to="{ name: 'database_aircraft_type', params: {
                      icaoCode: aircraft.aircraftType.icaoCode } }">
                      {{ aircraft.aircraftType.manufacturer }} {{ aircraft.aircraftType.name }}
                    </RouterLink>
                    <template v-else>
                      -
                    </template>

                  </td>
                  <td>{{ aircraft.serialNumber }}</td>
                  <td>

                    <RouterLink v-if="aircraft.operator" :to="{ name: 'database_airline', params: {
                      icaoCode: aircraft.operator.icaoCode } }">
                      {{ aircraft.operator.name }}
                    </RouterLink>
                    <template v-else>
                      -
                    </template>

                  </td>
                  <td>

                    <template v-if="aircraft.registrationCountry">
                      <CountryFlag class="me-2" :country-code="aircraft.registrationCountry" height="16"/>
                      <CountryName :country-code="aircraft.registrationCountry"/>
                    </template>
                    <template v-else>
                      -
                    </template>

                  </td>
                </tr>
              </template>

              <template v-else>
                <tr v-for="index in $m.range(0, 24).toArray()" :key="index">
                  <td>
                    <ContentLoader width="100" height="15"/>
                  </td>
                  <td>
                    <ContentLoader width="100" height="15"/>
                  </td>
                  <td>
                    <ContentLoader width="200" height="15"/>
                  </td>
                  <td>
                    <ContentLoader width="200" height="15"/>
                  </td>
                  <td>
                    <ContentLoader width="200" height="15"/>
                  </td>
                  <td>
                    <ContentLoader width="100" height="15"/>
                  </td>
                  <td>
                    <ContentLoader width="200" height="15"/>
                  </td>
                  <td>
                    <ContentLoader width="232" height="16">
                      <rect x="0" y="0" width="24" height="16" rx="2" ry="2"/>
                      <rect x="32" y="0.5" width="200" height="15" rx="2" ry="2"/>
                    </ContentLoader>
                  </td>
                </tr>
              </template>

            </tbody>
          </table>
        </div>
      </div>
    </template>

    <template #pagination>
      <Pagination :items="aircrafts" :items-loaded="aircraftsLoaded" v-model="page"/>
    </template>

  </DatabaseLayout>
</template>

<script>
import ColumnHeader from '@scripts/components/ColumnHeader'
import ContentLoader from '@scripts/components/ContentLoader'
import CountryFlag from '@scripts/components/CountryFlag'
import CountryName from '@scripts/components/CountryName'
import AircraftFamilySelect from '@scripts/components/form/fields/AircraftFamilySelect'
import AircraftTypeSelect from '@scripts/components/form/fields/AircraftTypeSelect'
import AirlineSelect from '@scripts/components/form/fields/AirlineSelect'
import CountrySelect from '@scripts/components/form/fields/CountrySelect'
import EngineTypeSelect from '@scripts/components/form/fields/EngineTypeSelect'
import OrderSelect from '@scripts/components/form/fields/OrderSelect'
import ListHeader from '@scripts/components/ListHeader'
import Pagination from '@scripts/components/Pagination'
import DatabaseLayout from '@scripts/layouts/DatabaseLayout'
import { Aircraft } from '@scripts/services/api'
import { CancelToken } from 'axios'
import { mapActions } from 'vuex'

export default {
  name: 'Aircrafts',
  components: {
    AircraftFamilySelect,
    AircraftTypeSelect,
    AirlineSelect,
    ColumnHeader,
    ContentLoader,
    CountryFlag,
    CountryName,
    CountrySelect,
    DatabaseLayout,
    EngineTypeSelect,
    ListHeader,
    OrderSelect,
    Pagination
  },
  methods: {
    ...mapActions([
      'setMetaDescription',
      'setMetaRobots',
      'setMetaTitle',
      'setMetaUrl',
      'setPageTitle'
    ]),
    loadAircrafts () {
      this.cancelToken?.cancel('Concurrent request')
      this.cancelToken = CancelToken.source()
      this.aircraftsLoaded = false

      Aircraft.getAircrafts({
        cancelToken: this.cancelToken.token,
        params: {
          ...this.filters,
          order: this.order,
          page: this.page,
          properties: {
            ...['id', 'icao24bitAddress', 'manufacturer', 'model', 'registration', 'registrationCountry', 'serialNumber'],
            aircraftType: ['icaoCode', 'manufacturer', 'name'],
            firstPicture: ['url'],
            operator: ['icaoCode', 'logo', 'name']
          }
        }
      }).then(aircrafts => {
        this.aircrafts = aircrafts
        this.aircraftsLoaded = true
      })
    },
    parseQuery (query = {}) {
      const {
        aircraftFamily = [],
        'aircraftType.icaoCode': aircraftType = [],
        description = null,
        engineCount = null,
        engineType = [],
        icao24bitAddress = null,
        manufacturer = null,
        model = null,
        'operator.icaoCode': operator = [],
        order = {},
        page = 1,
        registration = null,
        registrationCountry = [],
        serialNumber = null
      } = query

      this.filters = {
        aircraftFamily,
        'aircraftType.icaoCode': aircraftType,
        description,
        engineCount,
        engineType,
        icao24bitAddress,
        manufacturer,
        model,
        'operator.icaoCode': operator,
        registration,
        registrationCountry,
        serialNumber
      }

      this.order = { ...order }
      this.page = page
    },
    resetFilters () {
      this.filters = {}
      this.page = 1
    }
  },
  watch: {
    '$i18n.locale': {
      immediate: true,
      handler () {
        this.setMetaDescription(this.$t('meta_description.aircrafts'))
        this.setMetaTitle(this.$t('aircraft__p'))
        this.setPageTitle(this.$t('aircraft__p'))
      }
    },
    '$route.query': {
      deep: true,
      immediate: true,
      handler (query) {
        if (this.$route.name === 'database_aircrafts') {
          this.parseQuery(query)
          this.loadAircrafts()
        }
      }
    },
    filters: {
      deep: true,
      handler (filters, oldFilters) {
        if (filters === oldFilters) {
          this.page = 1
        }

        this.$router.replace({
          name: 'database_aircrafts',
          query: {
            ...filters,
            order: this.order,
            page: this.page
          }
        })
      }
    },
    order: {
      deep: true,
      handler (order) {
        this.$router.replace({
          name: 'database_aircrafts',
          query: {
            ...this.filters,
            order,
            page: this.page
          }
        })
      }
    },
    page (page) {
      this.$router.push({
        name: 'database_aircrafts',
        query: {
          ...this.filters,
          order: this.order,
          page
        }
      })
    }
  },
  data () {
    return {
      aircrafts: null,
      aircraftsLoaded: false,
      cancelToken: null,
      filters: {},
      order: {},
      page: 1
    }
  },
  mounted () {
    this.setMetaRobots('index,follow,noarchive')
    this.setMetaUrl(this.$route.path)
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
