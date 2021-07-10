<template>
  <DatabaseLayout>

    <template #header>
      <h1 class="card-title">{{ $t('aircraft_types') }}</h1>
      <ListHeader :items="aircraftTypes" :items-loaded="aircraftTypesLoaded"/>
    </template>

    <template #filters>
      <div class="row g-3">
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterAircraftFamily">{{ $t('label.aircraft_family') }}</label>
          <AircraftFamilySelect id="filterAircraftFamily" mode="multiple" v-model="filters.aircraftFamily"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterManufacturer">{{ $t('label.manufacturer') }}</label>
          <input class="form-control" id="filterManufacturer" type="text"
                 :placeholder="$t('enter_a_manufacturer')" v-model="filters.manufacturer">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterName">{{ $t('label.name') }}</label>
          <input class="form-control" id="filterName" type="text"
                 :placeholder="$t('enter_a_name')" v-model="filters.name">
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
          <label class="form-label" for="filterIcaoCode">{{ $t('label.icao_code') }}</label>
          <input class="form-control" id="filterIcaoCode" type="text"
                 :placeholder="$t('enter_an_icao_code')" v-model="filters.icaoCode">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterIataCode">{{ $t('label.iata_code') }}</label>
          <input class="form-control" id="filterIataCode" type="text"
                 :placeholder="$t('enter_an_iata_code')" v-model="filters.iataCode">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterWtc">{{ $t('label.icao_wake_turbulence_category') }}</label>
          <WtcSelect id="filterWtc" mode="multiple" v-model="filters.wtc"/>
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
          <label class="form-label" for="orderName">{{ $t('label.name') }}</label>
          <OrderSelect id="orderName" v-model="order.name"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="orderIcaoCode">{{ $t('label.icao_code') }}</label>
          <OrderSelect id="orderIcaoCode" v-model="order.icaoCode"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="orderIataCode">{{ $t('label.iata_code') }}</label>
          <OrderSelect id="orderIataCode" v-model="order.iataCode"/>
        </div>
      </div>
    </template>

    <template #gridView>
      <div v-if="aircraftTypesLoaded" class="row g-3">
        <div v-for="aircraftType in aircraftTypes['hydra:member']" :key="aircraftType.id"
             class="col-md-6 col-lg-4 col-xl-3 d-flex flex-column">
          <div class="card h-100">
            <RouterLink :to="{ name: 'database_aircraft_type', params: { icaoCode: aircraftType.icaoCode } }">
              <div class="card-img-top overflow-hidden" :style="{ height: '250px' }">

                <img v-if="aircraftType.firstPicture" class="img-cover" :src="aircraftType.firstPicture.url" alt="">
                <img v-else class="img-cover" src="@images/no-picture.webp" alt="">

              </div>
            </RouterLink>
            <div class="card-body">
              <h4 class="card-title text-truncate">
                <RouterLink :to="{ name: 'database_aircraft_type', params: { icaoCode: aircraftType.icaoCode } }">
                  {{ aircraftType.manufacturer }} {{ aircraftType.name }}
                </RouterLink>
              </h4>
              <div class="card-subtitle text-truncate">
                <i18n-t keypath="label_value.icao_code">
                  <template #icaoCode>
                    <strong>{{ aircraftType.icaoCode }}</strong>
                  </template>
                </i18n-t>
                -
                <i18n-t keypath="label_value.iata_code">
                  <template #iataCode>
                    <strong>{{ aircraftType.iataCode || '-' }}</strong>
                  </template>
                </i18n-t>
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
              <ContentLoader width="730" height="44.93">
                <rect x="0" y="0" width="100" height="18.75" rx="2" ry="2"/>
                <rect x="0" y="25.43" width="200" height="15" rx="2" ry="2"/>
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
                <th scope="col" class="col-2">
                  <ColumnHeader v-model="order.manufacturer">
                    {{ $t('manufacturer') }}
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-2">
                  <ColumnHeader v-model="order.name">
                    {{ $t('name') }}
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-1">
                  <ColumnHeader v-model="order.icaoCode">
                    {{ $t('icao_code') }}
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-1">
                  <ColumnHeader v-model="order.iataCode">
                    {{ $t('iata_code') }}
                  </ColumnHeader>
                </th>
              </tr>
            </thead>
            <tbody>

              <template v-if="aircraftTypesLoaded">
                <tr v-for="aircraftType in aircraftTypes['hydra:member']" :key="aircraftType.id">
                  <td>{{ aircraftType.manufacturer }}</td>
                  <td>
                    <RouterLink :to="{ name: 'database_aircraft_type', params: { icaoCode: aircraftType.icaoCode } }">
                      {{ aircraftType.name }}
                    </RouterLink>
                  </td>
                  <td>{{ aircraftType.icaoCode }}</td>
                  <td>{{ aircraftType.iataCode || '-' }}</td>
                </tr>
              </template>

              <template v-else>
                <tr v-for="index in $m.range(0, 24).toArray()" :key="index">
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
                    <ContentLoader width="100" height="15"/>
                  </td>
                </tr>
              </template>

            </tbody>
          </table>
        </div>
      </div>
    </template>

    <template #pagination>
      <Pagination :items="aircraftTypes" :items-loaded="aircraftTypesLoaded" v-model="page"/>
    </template>

  </DatabaseLayout>
</template>

<script>
import ColumnHeader from '@scripts/components/ColumnHeader'
import ContentLoader from '@scripts/components/ContentLoader'
import AircraftFamilySelect from '@scripts/components/form/fields/AircraftFamilySelect'
import EngineTypeSelect from '@scripts/components/form/fields/EngineTypeSelect'
import OrderSelect from '@scripts/components/form/fields/OrderSelect'
import WtcSelect from '@scripts/components/form/fields/WtcSelect'
import ListHeader from '@scripts/components/ListHeader'
import Pagination from '@scripts/components/Pagination'
import DatabaseLayout from '@scripts/layouts/DatabaseLayout'
import { AircraftType } from '@scripts/services/api'
import { CancelToken } from 'axios'
import { mapActions } from 'vuex'

export default {
  name: 'AircraftTypes',
  components: {
    AircraftFamilySelect,
    ColumnHeader,
    ContentLoader,
    DatabaseLayout,
    EngineTypeSelect,
    ListHeader,
    OrderSelect,
    Pagination,
    WtcSelect
  },
  methods: {
    ...mapActions([
      'setMetaDescription',
      'setMetaRobots',
      'setMetaTitle',
      'setMetaUrl',
      'setPageTitle'
    ]),
    loadAircraftTypes () {
      this.cancelToken?.cancel('Concurrent request')
      this.cancelToken = CancelToken.source()
      this.aircraftTypesLoaded = false

      AircraftType.getAircraftTypes({
        cancelToken: this.cancelToken.token,
        params: {
          ...this.filters,
          order: this.order,
          page: this.page,
          properties: {
            ...['id', 'iataCode', 'icaoCode', 'manufacturer', 'name'],
            firstPicture: ['url']
          }
        }
      }).then(aircraftTypes => {
        this.aircraftTypes = aircraftTypes
        this.aircraftTypesLoaded = true
      })
    },
    parseQuery (query = {}) {
      const {
        aircraftFamily = [],
        description = null,
        engineCount = null,
        engineType = [],
        iataCode = null,
        icaoCode = null,
        manufacturer = null,
        name = null,
        order = {},
        page = 1,
        wtc = []
      } = query

      this.filters = {
        aircraftFamily,
        description,
        engineCount,
        engineType,
        iataCode,
        icaoCode,
        manufacturer,
        name,
        wtc
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
        this.setMetaDescription(this.$t('meta_description.aircraft_types'))
        this.setMetaTitle(this.$t('aircraft_types'))
        this.setPageTitle(this.$t('aircraft_types'))
      }
    },
    '$route.query': {
      deep: true,
      immediate: true,
      handler (query) {
        if (this.$route.name === 'database_aircraft_types') {
          this.parseQuery(query)
          this.loadAircraftTypes()
        }
      }
    },
    filters: {
      deep: true,
      handler (filters, oldFilters) {
        if (filters === oldFilters) {
          this.page = 1
        }

        this.$router.push({
          name: 'database_aircraft_types',
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
        this.$router.push({
          name: 'database_aircraft_types',
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
        name: 'database_aircraft_types',
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
      aircraftTypes: null,
      aircraftTypesLoaded: false,
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
