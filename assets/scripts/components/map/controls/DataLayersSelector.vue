<template>
  <div class="dropend">
    <button class="map-control" type="button" data-bs-toggle="dropdown"
            :title="$t('data')" aria-haspopup="true" aria-expanded="false">
      <FontAwesomeIcon :icon="['fal', 'map-location']" aria-hidden="true"/>
    </button>
    <div class="dropdown-menu map-control-menu ms-2">
      <h4>{{ $t('data') }}</h4>
      <div v-if="!forceShowAircrafts" class="form-check">
        <label class="form-check-label" for="inputAircraftsLayer">{{ $t('aircraft__p') }}</label>
        <input class="form-check-input" id="inputAircraftsLayer" type="checkbox"
               :checked="showAircrafts" @change="setShowAircrafts($event.target.checked)">
      </div>
      <div v-if="!forceShowAirports" class="form-check">
        <label class="form-check-label" for="inputAirportsLayer">{{ $t('airports') }}</label>
        <input class="form-check-input" id="inputAirportsLayer" type="checkbox"
               :checked="showAirports" @change="setShowAirports($event.target.checked)">
      </div>
      <div v-if="!forceShowNavaids" class="form-check">
        <label class="form-check-label" for="inputNavaidsLayer">{{ $t('navaids') }}</label>
        <input class="form-check-input" id="inputNavaidsLayer" type="checkbox"
               :checked="showNavaids" @change="setShowNavaids($event.target.checked)">
      </div>
      <div v-if="!forceShowFixes" class="form-check">
        <label class="form-check-label" for="inputFixesLayer">{{ $t('fixes') }}</label>
        <input class="form-check-input" id="inputFixesLayer" type="checkbox"
               :checked="showFixes" @change="setShowFixes($event.target.checked)">
      </div>
    </div>
  </div>
</template>

<script>
import FontAwesomeIcon from '@scripts/fontawesome'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'DataLayersSelector',
  components: {
    FontAwesomeIcon
  },
  inject: [
    'forceShowAircrafts',
    'forceShowAirports',
    'forceShowFixes',
    'forceShowNavaids'
  ],
  computed: {
    ...mapGetters([
      'showAircrafts',
      'showAirports',
      'showFixes',
      'showNavaids'
    ])
  },
  methods: {
    ...mapActions([
      'setShowAircrafts',
      'setShowAirports',
      'setShowFixes',
      'setShowNavaids'
    ])
  }
}
</script>
