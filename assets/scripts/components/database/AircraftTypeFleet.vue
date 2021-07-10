<template>
  <div class="card card-body">
    <h3 class="card-title">{{ $t('fleet') }}</h3>

    <template v-if="!aircraftsLoaded || aircrafts['hydra:totalItems']">
      <ListHeader :items="aircrafts" :items-loaded="aircraftsLoaded"/>
      <hr>
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
                <ColumnHeader v-model="order.serialNumber">
                  <abbr data-bs-toggle="tooltip" :title="$t('manufacturer_serial_number')">
                    {{ $t('msn') }}
                  </abbr>
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
              <th scope="col" class="col-3">
                <ColumnHeader v-model="order['operator.name']">
                  {{ $t('operator') }}
                </ColumnHeader>
              </th>
              <th scope="col" class="col-3">
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
                <td>{{ aircraft.serialNumber }}</td>
                <td>{{ aircraft.manufacturer }}</td>
                <td>{{ aircraft.model }}</td>
                <td>

                  <template v-if="aircraft.operator">
                    <RouterLink :to="{ name: 'database_airline', params: {
                      icaoCode: aircraft.operator.icaoCode } }">
                      {{ aircraft.operator.name }}
                    </RouterLink>
                  </template>
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
              <tr v-for="index in $m.range(0, 10).toArray()" :key="index">
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
      <Pagination class="mt-3" :items="aircrafts" :itemsLoaded="aircraftsLoaded" v-model="page"/>
    </template>

    <template v-else>
      <NoDataAvailable/>
    </template>

  </div>
</template>

<script>
import ColumnHeader from '@scripts/components/ColumnHeader'
import ContentLoader from '@scripts/components/ContentLoader'
import CountryFlag from '@scripts/components/CountryFlag'
import CountryName from '@scripts/components/CountryName'
import ListHeader from '@scripts/components/ListHeader'
import NoDataAvailable from '@scripts/components/NoDataAvailable'
import Pagination from '@scripts/components/Pagination'
import { Aircraft } from '@scripts/services/api'
import { CancelToken } from 'axios'

export default {
  name: 'AircraftTypeFleet',
  components: {
    ColumnHeader,
    ContentLoader,
    CountryFlag,
    CountryName,
    ListHeader,
    NoDataAvailable,
    Pagination
  },
  props: {
    aircraftType: String
  },
  methods: {
    loadAircrafts () {
      this.cancelToken?.cancel('Concurrent request')
      this.cancelToken = CancelToken.source()
      this.aircraftsLoaded = false

      Aircraft.getAircrafts({
        cancelToken: this.cancelToken.token,
        params: {
          'aircraftType.icaoCode': this.aircraftType,
          itemsPerPage: 10,
          order: this.order,
          page: this.page,
          properties: {
            ...[
              'id',
              'icao24bitAddress',
              'manufacturer',
              'model',
              'registration',
              'registrationCountry',
              'serialNumber'
            ],
            operator: ['icaoCode', 'name']
          }
        }
      }).then(aircrafts => {
        this.aircrafts = aircrafts
        this.aircraftsLoaded = true
      })
    }
  },
  watch: {
    order: {
      deep: true,
      handler () {
        this.loadAircrafts()
      }
    },
    page () {
      this.loadAircrafts()
    }
  },
  data () {
    return {
      aircrafts: null,
      aircraftsLoaded: false,
      cancelToken: null,
      order: {},
      page: 1
    }
  },
  mounted () {
    this.loadAircrafts()
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
