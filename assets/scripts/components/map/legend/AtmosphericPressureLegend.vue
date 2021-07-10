<template>

  <div v-if="showAtmosphericPressure" class="legend">
    <div class="legend-bar legend-bar-atmospheric-pressure"></div>
    <div class="d-flex justify-content-between">
      <div class="legend-start">950&nbsp;hPa</div>
      <div class="legend-text">{{ $t('atmospheric_pressure') }}</div>
      <div class="legend-end">1070&nbsp;hPa</div>
    </div>
  </div>

</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'AtmosphericPressureLegend',
  computed: {
    ...mapGetters(['showAtmosphericPressure'])
  }
}
</script>
