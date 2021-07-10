<template>

  <div v-if="showWindSpeed" class="legend">
    <div class="legend-bar legend-bar-wind-speed"></div>
    <div class="d-flex justify-content-between">
      <div class="legend-start">0&nbsp;kt</div>
      <div class="legend-text">{{ $t('wind_speed') }}</div>
      <div class="legend-end">400&nbsp;kt</div>
    </div>
  </div>

</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'WindSpeedLegend',
  computed: {
    ...mapGetters(['showWindSpeed'])
  }
}
</script>
