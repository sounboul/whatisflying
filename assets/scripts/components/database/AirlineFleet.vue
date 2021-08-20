<template>
  <div class="card card-body">
    <div class="d-flex justify-content-between">
      <h3 class="card-title">{{ $t('fleet') }}</h3>
      <RouterLink :to="{ name: 'database_aircrafts', query: {
          'operator.icaoCode': [ airline ] } }">
        <span class="visually-hidden">{{ $t('maximize') }}</span>
        <FontAwesomeIcon :icon="['far', 'arrows-maximize']" aria-hidden="true"/>
      </RouterLink>
    </div>

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
              <th scope="col" class="col-2">
                <ColumnHeader v-model="order.manufactured">
                  {{ $t('manufactured__m') }}
                </ColumnHeader>
              </th>
              <th scope="col" class="col-2">
                <ColumnHeader v-model="order.registered">
                  {{ $t('registered__m') }}
                </ColumnHeader>
              </th>
              <th scope="col" class="col-2">
                <ColumnHeader v-model="order.registeredUntil">
                  {{ $t('registered_until__m') }}
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

                  <template v-if="aircraft.manufactured">
                    {{ $dt.fromISO(aircraft.manufactured).setLocale($i18n.locale).toLocaleString($dt.DATE_MED) }}
                    ({{ $dt.fromISO(aircraft.manufactured).setLocale($i18n.locale).toRelative() }})
                  </template>
                  <template v-else>
                    -
                  </template>

                </td>
                <td>

                  <template v-if="aircraft.registered">
                    {{ $dt.fromISO(aircraft.registered).setLocale($i18n.locale).toLocaleString($dt.DATE_MED) }}
                    ({{ $dt.fromISO(aircraft.registered).setLocale($i18n.locale).toRelative() }})
                  </template>
                  <template v-else>
                    -
                  </template>

                </td>
                <td>

                  <template v-if="aircraft.registeredUntil">
                    {{ $dt.fromISO(aircraft.registeredUntil).setLocale($i18n.locale).toLocaleString($dt.DATE_MED) }}
                    ({{ $dt.fromISO(aircraft.registeredUntil).setLocale($i18n.locale).toRelative() }})
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
                  <ContentLoader width="200" height="15"/>
                </td>
                <td>
                  <ContentLoader width="200" height="15"/>
                </td>
                <td>
                  <ContentLoader width="200" height="15"/>
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
import ListHeader from '@scripts/components/ListHeader'
import NoDataAvailable from '@scripts/components/NoDataAvailable'
import Pagination from '@scripts/components/Pagination'
import FontAwesomeIcon from '@scripts/fontawesome'
import { Airline } from '@scripts/services/api'
import { CancelToken } from 'axios'

export default {
  name: 'Aircrafts',
  components: {
    ColumnHeader,
    ContentLoader,
    FontAwesomeIcon,
    ListHeader,
    NoDataAvailable,
    Pagination
  },
  props: {
    airline: String
  },
  methods: {
    loadAircrafts () {
      this.cancelToken?.cancel('Concurrent request')
      this.cancelToken = CancelToken.source()
      this.aircraftsLoaded = false

      Airline.getAircraft(this.airline, {
        cancelToken: this.cancelToken.token,
        params: {
          itemsPerPage: 10,
          order: this.order,
          page: this.page,
          properties: [
            'id',
            'icao24bitAddress',
            'manufactured',
            'manufacturer',
            'model',
            'registered',
            'registeredUntil',
            'registration',
            'serialNumber'
          ]
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
