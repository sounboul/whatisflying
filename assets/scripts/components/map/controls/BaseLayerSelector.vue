<template>
  <div class="dropend">
    <button class="map-control" type="button" data-bs-toggle="dropdown"
            :title="$t('base_layer')" aria-haspopup="true" aria-expanded="false">
      <FontAwesomeIcon :icon="['fal', 'map']" aria-hidden="true"/>
    </button>
    <div class="dropdown-menu map-control-menu ms-2">
      <h4>{{ $t('base_layer') }}</h4>
      <div class="form-check">
        <label class="form-check-label" for="inputRoadMapLayer">{{ $t('road_map') }}</label>
        <input class="form-check-input" id="inputRoadMapLayer" name="baseLayer" type="radio"
               :checked="baseLayer === 'roadmap'" @change="setBaseLayer('roadmap')">
      </div>
      <div class="form-check">
        <label class="form-check-label" for="inputSatelliteLayer">{{ $t('satellite') }}</label>
        <input class="form-check-input" id="inputSatelliteLayer" name="baseLayer" type="radio"
               :checked="baseLayer === 'satellite'" @change="setBaseLayer('satellite')">
      </div>
    </div>
  </div>
</template>

<script>
import FontAwesomeIcon from '@scripts/fontawesome'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'BaseLayerSelector',
  components: {
    FontAwesomeIcon
  },
  computed: {
    ...mapGetters(['baseLayer'])
  },
  methods: {
    ...mapActions(['setBaseLayer'])
  }
}
</script>
