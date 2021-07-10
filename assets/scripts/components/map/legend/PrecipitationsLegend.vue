<template>

  <div v-if="showPrecipitations" class="legend">
    <div class="legend-bar legend-bar-precipitations"></div>
    <div class="d-flex justify-content-between">
      <div class="legend-start">0&nbsp;mm</div>
      <div class="legend-text">{{ $t('precipitations') }}</div>
      <div class="legend-end">200&nbsp;mm</div>
    </div>
  </div>

</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'PrecipitationsLegend',
  computed: {
    ...mapGetters(['showPrecipitations'])
  }
}
</script>
