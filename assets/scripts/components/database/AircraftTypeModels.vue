<template>
  <div class="card card-body">
    <h3 class="card-title">{{ $t('models') }}</h3>

    <template v-if="!aircraftModelsLoaded || aircraftModels['hydra:totalItems']">
      <ListHeader :items="aircraftModels" :items-loaded="aircraftModelsLoaded"/>
      <hr>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead>
            <tr>
              <th scope="col" class="col-2">
                <ColumnHeader v-model="order.name">
                  {{ $t('model') }}
                </ColumnHeader>
              </th>
              <th scope="col" class="col-2">
                <ColumnHeader v-model="order.engineManufacturer">
                  {{ $t('engine_manufacturer') }}
                </ColumnHeader>
              </th>
              <th scope="col" class="col-6">
                <ColumnHeader v-model="order.engineModel">
                  {{ $t('engine_models') }}
                </ColumnHeader>
              </th>
              <th scope="col" class="col-2">
                <ColumnHeader v-model="order.certified">
                  {{ $t('certification') }}
                </ColumnHeader>
              </th>
            </tr>
          </thead>
          <tbody>

            <template v-if="aircraftModelsLoaded">
              <tr v-for="aircraftModel in aircraftModels['hydra:member']" :key="aircraftModel.id">
                <td>{{ aircraftModel.name }}</td>
                <td>{{ aircraftModel.engineManufacturer }}</td>
                <td>{{ aircraftModel.engineModel.split(';').join(' / ') }}</td>
                <td>
                  {{ $dt.fromISO(aircraftModel.certified).toLocaleString($dt.DATE_MED) }}

                  <a v-if="aircraftModel.aircraftType.typeCertificate" rel="nofollow noreferrer"
                     :href="aircraftModel.aircraftType.typeCertificate">
                    <span data-bs-toggle="tooltip" :title="$t('download_the_type_certificate')">
                      <FontAwesomeIcon class="ms-2" :icon="['far', 'file-pdf']" aria-hidden="true"/>
                    </span>
                  </a>

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
                  <ContentLoader width="300" height="15"/>
                </td>
                <td>
                  <ContentLoader width="100" height="15"/>
                </td>
              </tr>
            </template>

          </tbody>
        </table>
      </div>
      <Pagination class="mt-3" :items="aircraftModels" :itemsLoaded="aircraftModelsLoaded" v-model="page"/>
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
import { AircraftType } from '@scripts/services/api'
import { CancelToken } from 'axios'

export default {
  name: 'AircraftModels',
  components: {
    ColumnHeader,
    ContentLoader,
    FontAwesomeIcon,
    ListHeader,
    NoDataAvailable,
    Pagination
  },
  props: {
    aircraftType: String
  },
  methods: {
    loadAircraftModels () {
      this.cancelToken?.cancel('Concurrent request')
      this.cancelToken = CancelToken.source()
      this.aircraftModelsLoaded = false

      AircraftType.getAircraftModels(this.aircraftType, {
        cancelToken: this.cancelToken.token,
        params: {
          itemsPerPage: 10,
          order: this.order,
          page: this.page,
          properties: {
            ...['id', 'certified', 'engineManufacturer', 'engineModel', 'name'],
            aircraftType: ['description', 'typeCertificate']
          }
        }
      }).then(aircraftModels => {
        this.aircraftModels = aircraftModels
        this.aircraftModelsLoaded = true
      })
    }
  },
  watch: {
    order: {
      deep: true,
      handler () {
        this.loadAircraftModels()
      }
    },
    page () {
      this.loadAircraftModels()
    }
  },
  data () {
    return {
      aircraftModels: null,
      aircraftModelsLoaded: false,
      cancelToken: null,
      order: {},
      page: 1
    }
  },
  mounted () {
    this.loadAircraftModels()
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
