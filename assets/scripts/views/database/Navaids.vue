<template>
  <DatabaseLayout>

    <template #header>
      <h1 class="card-title">{{ $t('navaids') }}</h1>
      <ListHeader :items="navaids" :items-loaded="navaidsLoaded"/>
    </template>

    <template #filters>
      <div class="row g-3">
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterName">{{ $t('label.name') }}</label>
          <input class="form-control" id="filterName" type="text"
                 :placeholder="$t('enter_a_name')" v-model="filters.name">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterIdentifier">{{ $t('label.identifier') }}</label>
          <input class="form-control" id="filterIdentifier" type="text"
                 :placeholder="$t('enter_an_identifier')" v-model="filters.identifier">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterType">{{ $t('label.type') }}</label>
          <NavaidTypeSelect id="filterType" mode="multiple" v-model="filters.type"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterCountry">{{ $t('label.country') }}</label>
          <CountrySelect id="filterCountry" mode="multiple" v-model="filters.country"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterAirport">{{ $t('label.associated_airport') }}</label>
          <AirportSelect id="filterAirport" mode="multiple" v-model="filters['airport.icaoCode']"/>
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
          <label class="form-label" for="orderCountry">{{ $t('label.country') }}</label>
          <OrderSelect id="orderCountry" v-model="order.country"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="orderIdentifier">{{ $t('label.identifier') }}</label>
          <OrderSelect id="orderIdentifier" v-model="order.identifier"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="orderName">{{ $t('label.name') }}</label>
          <OrderSelect id="orderName" v-model="order.name"/>
        </div>
      </div>
    </template>

    <template #gridView>
      <div v-if="navaidsLoaded" class="row g-3">
        <div v-for="navaid in navaids['hydra:member']" :key="navaid.id"
             class="col-md-6 col-xl-3 d-flex flex-column">
          <div class="card h-100">
            <RouterLink :to="{ name: 'database_navaid', params: { slug: navaid.slug } }">
              <div class="card-img-top overflow-hidden" :style="{ height: '250px' }">
                <StaticMap class="img-cover" width="900" height="500" :params="getMapParams(navaid)"/>
              </div>
            </RouterLink>
            <div class="card-body">
              <h4 class="card-title text-truncate">
                <RouterLink :to="{ name: 'database_navaid', params: { slug: navaid.slug } }">
                  {{ navaid.name }}
                </RouterLink>
              </h4>
              <div class="card-subtitle">
                <i18n-t keypath="label_value.identifier">
                  <template #identifier>
                    <strong>{{ navaid.identifier }}</strong>
                  </template>
                </i18n-t>
              </div>
              <div class="mt-3 small text-truncate">
                <CountryFlag class="me-2" :country-code="navaid.country" height="16"/>
                <CountryName :country-code="navaid.country"/>
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
                  <ColumnHeader v-model="order.identifier">
                    {{ $t('identifier') }}
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-1">
                  <ColumnHeader v-model="order.iataCode">
                    {{ $t('type') }}
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

              <template v-if="navaidsLoaded">
                <tr v-for="navaid in navaids['hydra:member']" :key="navaid.id">
                  <td>
                    <RouterLink :to="{ name: 'database_navaid', params: { slug: navaid.slug } }">
                      {{ navaid.name }}
                    </RouterLink>
                  </td>
                  <td>{{ navaid.identifier }}</td>
                  <td>
                    <NavaidIcon class="me-2" :navaid-type="navaid.type" height="16"/>
                    {{ navaid.type }}
                  </td>
                  <td>
                    <CountryFlag class="me-2" :country-code="navaid.country" height="16"/>
                    <CountryName :country-code="navaid.country"/>
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
                    <ContentLoader width="124" height="16">
                      <circle cx="8" cy="8" r="8"/>
                      <rect x="24" y="0.5" width="100" height="15" rx="2" ry="2"/>
                    </ContentLoader>
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
      <Pagination :items="navaids" :items-loaded="navaidsLoaded" v-model="page"/>
    </template>

  </DatabaseLayout>
</template>

<script>
import ColumnHeader from '@scripts/components/ColumnHeader'
import ContentLoader from '@scripts/components/ContentLoader'
import CountryFlag from '@scripts/components/CountryFlag'
import CountryName from '@scripts/components/CountryName'
import AirportSelect from '@scripts/components/form/fields/AirportSelect'
import CountrySelect from '@scripts/components/form/fields/CountrySelect'
import NavaidTypeSelect from '@scripts/components/form/fields/NavaidTypeSelect'
import OrderSelect from '@scripts/components/form/fields/OrderSelect'
import ListHeader from '@scripts/components/ListHeader'
import NavaidIcon from '@scripts/components/NavaidIcon'
import Pagination from '@scripts/components/Pagination'
import StaticMap from '@scripts/components/StaticMap'
import DatabaseLayout from '@scripts/layouts/DatabaseLayout'
import { Navaid } from '@scripts/services/api'
import { CancelToken } from 'axios'
import { mapActions } from 'vuex'

export default {
  name: 'Navaids',
  components: {
    AirportSelect,
    ColumnHeader,
    ContentLoader,
    CountryFlag,
    CountryName,
    CountrySelect,
    DatabaseLayout,
    ListHeader,
    NavaidIcon,
    NavaidTypeSelect,
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
    getMapParams (navaid) {
      const { latitude, longitude } = navaid
      return {
        r: [latitude, longitude].join(','),
        lw: 18,
        z: 5
      }
    },
    loadNavaids () {
      this.cancelToken?.cancel('Concurrent request')
      this.cancelToken = CancelToken.source()
      this.navaidsLoaded = false

      Navaid.getNavaids({
        cancelToken: this.cancelToken.token,
        params: {
          ...this.filters,
          order: this.order,
          page: this.page,
          properties: ['id', 'country', 'identifier', 'latitude', 'longitude', 'name', 'slug', 'type']
        }
      }).then(navaids => {
        this.navaids = navaids
        this.navaidsLoaded = true
      })
    },
    parseQuery (query = {}) {
      const {
        'airport.icaoCode': airport = [],
        country = [],
        identifier = null,
        name = null,
        order = {},
        page = 1,
        type = []
      } = query

      this.filters = {
        'airport.icaoCode': airport,
        country,
        identifier,
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
        this.setMetaDescription(this.$t('meta_description.navaids'))
        this.setMetaTitle(this.$t('navaids'))
        this.setPageTitle(this.$t('navaids'))
      }
    },
    '$route.query': {
      deep: true,
      immediate: true,
      handler (query) {
        if (this.$route.name === 'database_navaids') {
          this.parseQuery(query)
          this.loadNavaids()
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
          name: 'database_navaids',
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
          name: 'database_navaids',
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
        name: 'database_navaids',
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
      cancelToken: null,
      filters: {},
      navaids: null,
      navaidsLoaded: false,
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
