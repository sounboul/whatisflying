<template>
  <button v-if="geolocation" class="map-control" type="button"
          :title="$t('center_the_map_on_my_position')" @click="centerMap">
    <FontAwesomeIcon :icon="['fal', 'location-crosshairs']" aria-hidden="true"/>
  </button>
</template>

<script>
import FontAwesomeIcon from '@scripts/fontawesome'

export default {
  name: 'CenterMap',
  components: {
    FontAwesomeIcon
  },
  inject: [
    'geolocation',
    'map'
  ],
  methods: {
    centerMap () {
      const view = this.map.getView()
      view.setCenter(this.geolocation)
      view.setZoom(11)
    }
  }
}
</script>
