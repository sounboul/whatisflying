<template>
  <div class="dropdown">
    <input class="form-control" id="query" v-model="query" :placeholder="$t('search')">

    <ul class="dropdown-menu map-search-results" :class="{ 'dropdown-menu-dark': darkMode, 'show': showResults }">
      <li v-for="result in results" :key="result.id" class="dropdown-item"
          @click="centerMap(result.position, result.mapView)">
        {{ result.title }}
        <div class="small text-muted">
          {{ result.address.label }}
        </div>
      </li>
    </ul>

  </div>
</template>

<script>
import { Geocode } from '@scripts/services/here'
import { CancelToken } from 'axios'
import * as Projection from 'ol/proj'
import { mapGetters } from 'vuex'

export default {
  name: 'Search',
  inject: ['map'],
  computed: {
    ...mapGetters(['darkMode'])
  },
  methods: {
    centerMap (position, mapView) {
      this.showResults = false

      const view = this.map.getView()
      view.setCenter(Projection.transform([position.lng, position.lat], 'EPSG:4326', 'EPSG:3857'))

      if (mapView) {
        view.fit(Projection.transformExtent([mapView.west, mapView.south, mapView.east, mapView.north], 'EPSG:4326', 'EPSG:3857'), {
          size: this.map.getSize()
        })
      } else {
        view.setZoom(11)
      }
    },
    search (query) {
      clearTimeout(this.timeout)

      this.cancelToken?.cancel('Concurrent request')
      this.cancelToken = CancelToken.source()
      this.showResults = false

      if (query.length) {
        this.timeout = setTimeout(() => {
          Geocode.search({
            cancelToken: this.cancelToken.token,
            params: {
              q: query
            }
          }).then(results => {
            this.results = results
            if (results.length) {
              this.showResults = true
            }
          })
        }, 500)
      }
    }
  },
  watch: {
    '$i18n.locale' () {
      if (this.showResults) {
        this.search(this.query)
      }
    },
    query (value) {
      this.search(value)
    }
  },
  data () {
    return {
      cancelToken: null,
      query: null,
      results: null,
      showResults: false,
      timeout: null
    }
  },
  unmounted () {
    clearTimeout(this.timeout)
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
