<template>
  <DatabaseLayout>

    <template #header>
      <h1 class="card-title">{{ $t('airports') }}</h1>
      <ListHeader :items="airports" :items-loaded="airportsLoaded"/>
    </template>

    <template #filters>
      <div class="row g-3">
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterName">{{ $t('label.name') }}</label>
          <input class="form-control" id="filterName" type="text"
                 :placeholder="$t('enter_a_name')" v-model="filters.name">
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
          <label class="form-label" for="filterContinent">{{ $t('label.continent') }}</label>
          <ContinentSelect id="filterContinent" mode="multiple" v-model="filters.continent"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterCountry">{{ $t('label.country') }}</label>
          <CountrySelect id="filterCountry" mode="multiple" v-model="filters.country"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterFir">
            <abbr :title="$t('flight_information_region')">{{ $t('label.fir') }}</abbr>
          </label>
          <FirSelect id="filterFir" mode="multiple" v-model="filters['fir.icaoCode']"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterActive">{{ $t('label.in_service') }}</label>
          <BooleanSelect id="filterActive" v-model="filters.active"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterInternational">{{ $t('label.international__m') }}</label>
          <BooleanSelect id="filterInternational" v-model="filters.international"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterType">{{ $t('label.type') }}</label>
          <AirportTypeSelect id="filterType" mode="multiple" v-model="filters.type"/>
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
          <label class="form-label" for="orderName">{{ $t('label.name') }}</label>
          <OrderSelect id="orderName" v-model="order.name"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="orderIataCode">{{ $t('label.iata_code') }}</label>
          <OrderSelect id="orderIataCode" v-model="order.iataCode"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="orderIcaoCode">{{ $t('label.icao_code') }}</label>
          <OrderSelect id="orderIcaoCode" v-model="order.icaoCode"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="orderCountry">{{ $t('label.country') }}</label>
          <OrderSelect id="orderCountry" v-model="order.country"/>
        </div>
      </div>
    </template>

    <template #gridView>
      <div v-if="airportsLoaded" class="row g-3">
        <div v-for="airport in airports['hydra:member']" :key="airport.id"
             class="col-md-6 col-lg-4 col-xl-3 d-flex flex-column">
          <div class="card h-100">
            <RouterLink :to="{ name: 'database_airport', params: { icaoCode: airport.icaoCode } }">
              <div class="card-img-top overflow-hidden" :style="{ height: '250px' }">
                <StaticMap class="img-cover" width="900" height="500" :params="getMapParams(airport)"/>
              </div>
            </RouterLink>
            <div class="card-body">
              <h4 class="card-title text-truncate">
                <RouterLink :to="{ name: 'database_airport', params: { icaoCode: airport.icaoCode } }">
                  {{ airport.name }}
                </RouterLink>
              </h4>
              <div class="card-subtitle">
                <i18n-t keypath="label_value.icao_code">
                  <template #icaoCode>
                    <strong>{{ airport.icaoCode }}</strong>
                  </template>
                </i18n-t>
                -
                <i18n-t keypath="label_value.iata_code">
                  <template #iataCode>
                    <strong>{{ airport.iataCode || '-' }}</strong>
                  </template>
                </i18n-t>
              </div>
              <div class="mt-3 small text-truncate">
                <CountryFlag class="me-2" :country-code="airport.country" height="16"/>
                <CountryName :country-code="airport.country"/>
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
                <th scope="col" class="col-2">
                  <ColumnHeader v-model="order.country">
                    {{ $t('country') }}
                  </ColumnHeader>
                </th>
              </tr>
            </thead>
            <tbody>

              <template v-if="airportsLoaded">
                <tr v-for="airport in airports['hydra:member']" :key="airport.id">
                  <td>
                    <RouterLink :to="{ name: 'database_airport', params: { icaoCode: airport.icaoCode } }">
                      {{ airport.name }}
                    </RouterLink>
                  </td>
                  <td>{{ airport.icaoCode }}</td>
                  <td>{{ airport.iataCode || '-' }}</td>
                  <td>
                    <CountryFlag class="me-2" :country-code="airport.country" height="16"/>
                    <CountryName :country-code="airport.country"/>
                  </td>
                </tr>
              </template>

              <template v-else>
                <tr v-for="index in $m.range(0, 24).toArray()" :key="index">
                  <td>
                    <ContentLoader width="200" height="15"/>
                  </td>
                  <td>
                    <ContentLoader width="100" height="15"/>
                  </td>
                  <td>
                    <ContentLoader width="100" height="15"/>
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
      <Pagination :items="airports" :items-loaded="airportsLoaded" v-model="page"/>
    </template>

  </DatabaseLayout>
</template>

<script>
import ColumnHeader from '@scripts/components/ColumnHeader'
import ContentLoader from '@scripts/components/ContentLoader'
import CountryFlag from '@scripts/components/CountryFlag'
import CountryName from '@scripts/components/CountryName'
import AirportTypeSelect from '@scripts/components/form/fields/AirportTypeSelect'
import BooleanSelect from '@scripts/components/form/fields/BooleanSelect'
import ContinentSelect from '@scripts/components/form/fields/ContinentSelect'
import CountrySelect from '@scripts/components/form/fields/CountrySelect'
import FirSelect from '@scripts/components/form/fields/FirSelect'
import OrderSelect from '@scripts/components/form/fields/OrderSelect'
import ListHeader from '@scripts/components/ListHeader'
import Pagination from '@scripts/components/Pagination'
import StaticMap from '@scripts/components/StaticMap'
import DatabaseLayout from '@scripts/layouts/DatabaseLayout'
import { Airport } from '@scripts/services/api'
import { CancelToken } from 'axios'
import { mapActions } from 'vuex'

export default {
  name: 'Airports',
  components: {
    AirportTypeSelect,
    BooleanSelect,
    ColumnHeader,
    ContentLoader,
    ContinentSelect,
    CountryFlag,
    CountryName,
    CountrySelect,
    DatabaseLayout,
    FirSelect,
    ListHeader,
    OrderSelect,
    Pagination,
    StaticMap
  },
  methods: {
    ...mapActions([
      'setMetaDescription',
      'setMetaRobots',
      'setMetaTitle',
      'setMetaUrl',
      'setPageTitle'
    ]),
    getMapParams (airport) {
      const { latitude, longitude } = airport
      return {
        r: [latitude, longitude].join(','),
        lw: 18,
        z: 5
      }
    },
    loadAirports () {
      this.cancelToken?.cancel('Concurrent request')
      this.cancelToken = CancelToken.source()
      this.airportsLoaded = false

      Airport.getAirports({
        cancelToken: this.cancelToken.token,
        params: {
          ...this.filters,
          order: this.order,
          page: this.page,
          properties: ['id', 'country', 'iataCode', 'icaoCode', 'latitude', 'longitude', 'name']
        }
      }).then(airports => {
        this.airports = airports
        this.airportsLoaded = true
      })
    },
    parseQuery (query = {}) {
      const {
        active = null,
        continent = [],
        country = [],
        'fir.icaoCode': fir = [],
        iataCode = null,
        icaoCode = null,
        international = null,
        name = null,
        order = {},
        page = 1,
        type = null
      } = query

      this.filters = {
        active,
        continent,
        country,
        'fir.icaoCode': fir,
        iataCode,
        icaoCode,
        international,
        name,
        type
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
        this.setMetaDescription(this.$t('meta_description.airports'))
        this.setMetaTitle(this.$t('airports'))
        this.setPageTitle(this.$t('airports'))
      }
    },
    '$route.query': {
      deep: true,
      immediate: true,
      handler (query) {
        if (this.$route.name === 'database_airports') {
          this.parseQuery(query)
          this.loadAirports()
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
          name: 'database_airports',
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
          name: 'database_airports',
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
        name: 'database_airports',
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
      airports: null,
      airportsLoaded: false,
      cancelToken: null,
      filters: {},
      order: {},
      page: 1
    }
  },
  mounted () {
    this.setMetaRobots('index,follow,noarchive,noimageindex')
    this.setMetaUrl(this.$route.path)
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
