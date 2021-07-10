<template>
  <div class="dropend">
    <button class="map-control" type="button" data-bs-toggle="dropdown"
            :title="$t('weather')" aria-haspopup="true" aria-expanded="false">
      <FontAwesomeIcon :icon="['fal','cloud-sun']" aria-hidden="true"/>
    </button>
    <div class="dropdown-menu map-control-menu ms-2">
      <h4>{{ $t('weather') }}</h4>

      <template v-if="user">
        <div class="form-check">
          <label class="form-check-input" for="inputCloudCoverageLayer">{{ $t('cloud_coverage') }}</label>
          <input class="from-check-label" id="inputCloudCoverageLayer" type="checkbox"
                 :checked="showCloudCoverage" @change="setShowCloudCoverage($event.target.checked)">
        </div>
        <div class="form-check">
          <label class="form-check-input" for="inputPrecipitationsLayer">{{ $t('precipitations') }}</label>
          <input class="from-check-label" id="inputPrecipitationsLayer" type="checkbox"
                 :checked="showPrecipitations" @change="setShowPrecipitations($event.target.checked)">
        </div>
        <div class="form-check">
          <label class="form-check-input" for="inputAtmosphericPressureLayer">{{ $t('atmospheric_pressure') }}</label>
          <input class="from-check-label" id="inputAtmosphericPressureLayer" type="checkbox"
                 :checked="showAtmosphericPressure" @change="setShowAtmosphericPressure($event.target.checked)">
        </div>
        <div class="form-check">
          <label class="form-check-input" for="inputTemperatureLayer">{{ $t('temperature') }}</label>
          <input class="from-check-label" id="inputTemperatureLayer" type="checkbox"
                 :checked="showTemperature" @change="setShowTemperature($event.target.checked)">
        </div>
        <div class="form-check">
          <label class="form-check-input" for="inputWindSpeedLayer">{{ $t('wind_speed') }}</label>
          <input class="from-check-label" id="inputWindSpeedLayer" type="checkbox"
                 :checked="showWindSpeed" @change="setShowWindSpeed($event.target.checked)">
        </div>
      </template>

      <template v-else>
        <div class="text-center text-muted">
          <FontAwesomeIcon class="me-2" :icon="['far', 'lock']" aria-hidden="true"/>
          {{ $t('sign_in_to_unlock_weather') }}
        </div>
      </template>

    </div>
  </div>
</template>

<script>
import FontAwesomeIcon from '@scripts/fontawesome'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'WeatherLayersSelector',
  components: {
    FontAwesomeIcon
  },
  computed: {
    ...mapGetters([
      'showAtmosphericPressure',
      'showCloudCoverage',
      'showPrecipitations',
      'showTemperature',
      'showWindSpeed',
      'user'
    ])
  },
  methods: {
    ...mapActions([
      'setShowAtmosphericPressure',
      'setShowCloudCoverage',
      'setShowPrecipitations',
      'setShowTemperature',
      'setShowWindSpeed'
    ])
  }
}
</script>
