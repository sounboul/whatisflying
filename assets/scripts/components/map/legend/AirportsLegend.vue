<template>

  <div v-if="showAirportsLegend && (forceShowAirports || showAirports)" class="legend">
    <h4>{{ $t('airports') }}</h4>
    <div class="row g-2">
      <div class="col-12">
        <img class="me-2" src="@images/airport/small.svg" width="20" height="20" alt="">
        <div class="d-inline-block">
          {{ $t('small_airport_air_base') }}
        </div>
      </div>
      <div class="col-12">
        <img class="me-2" src="@images/airport/medium.svg" width="20" height="20" alt="">
        <div class="d-inline-block">
          {{ $t('medium_airport_air_base') }}
        </div>
      </div>
      <div class="col-12">
        <img class="me-2" src="@images/airport/large.svg" width="20" height="20" alt="">
        <div class="d-inline-block">
          {{ $t('large_airport_air_base') }}
        </div>
      </div>
    </div>
  </div>

</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'AirportsLegend',
  inject: ['forceShowAirports'],
  computed: {
    ...mapGetters([
      'showAirports',
      'showAirportsLegend'
    ])
  }
}
</script>
