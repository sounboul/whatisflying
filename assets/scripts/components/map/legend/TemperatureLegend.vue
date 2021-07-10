<template>

  <div v-if="showTemperature" class="legend">
    <div class="legend-bar legend-bar-temperature"></div>
    <div class="d-flex justify-content-between">
      <div class="legend-start">-40&nbsp;°C</div>
      <div class="legend-text">{{ $t('temperature') }}</div>
      <div class="legend-end">40&nbsp;°C</div>
    </div>
  </div>

</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'TemperatureLegend',
  computed: {
    ...mapGetters(['showTemperature'])
  }
}
</script>
