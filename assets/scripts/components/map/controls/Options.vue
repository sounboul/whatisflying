<template>
  <div class="dropend mt-2">
    <button class="map-control" type="button" data-bs-toggle="dropdown"
            :title="$t('options')" aria-haspopup="true" aria-expanded="false">
      <FontAwesomeIcon :icon="['fal', 'gear']" aria-hidden="true"/>
    </button>
    <div class="dropdown-menu map-control-menu ms-2">
      <h4>{{ $t('options') }}</h4>
      <div class="form-check">
        <label class="form-check-label" for="inputGraticule">{{ $t('graticule') }}</label>
        <input class="form-check-input" id="inputGraticule" type="checkbox"
               :checked="showGraticule" @change="setShowGraticule($event.target.checked)">
      </div>
      <div class="form-check">
        <label class="form-check-label" for="inputAircraftsLegend">{{ $t('aircraft_legend') }}</label>
        <input class="form-check-input" id="inputAircraftsLegend" type="checkbox"
               :checked="showAircraftsLegend" @change="setShowAircraftsLegend($event.target.checked)">
      </div>
      <div class="form-check">
        <label class="form-check-label" for="inputAirportsLegend">{{ $t('airports_legend') }}</label>
        <input class="form-check-input" id="inputAirportsLegend" type="checkbox"
               :checked="showAirportsLegend" @change="setShowAirportsLegend($event.target.checked)">
      </div>
      <div class="form-check">
        <label class="form-check-label" for="inputNavaidsLegend">{{ $t('navaids_legend') }}</label>
        <input class="form-check-input" id="inputNavaidsLegend" type="checkbox"
               :checked="showNavaidsLegend" @change="setShowNavaidsLegend($event.target.checked)">
      </div>
    </div>
  </div>
</template>

<script>
import FontAwesomeIcon from '@scripts/fontawesome'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'Options',
  components: {
    FontAwesomeIcon
  },
  computed: {
    ...mapGetters([
      'showGraticule',
      'showAircraftsLegend',
      'showAirportsLegend',
      'showNavaidsLegend'
    ])
  },
  methods: {
    ...mapActions([
      'setShowGraticule',
      'setShowAircraftsLegend',
      'setShowAirportsLegend',
      'setShowNavaidsLegend'
    ])
  }
}
</script>
