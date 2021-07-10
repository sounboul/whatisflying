<template>

  <div v-if="showCloudCoverage" class="legend">
    <div class="legend-bar legend-bar-cloud-coverage"></div>
    <div class="d-flex justify-content-between">
      <div class="legend-start">0&nbsp;%</div>
      <div class="legend-text">{{ $t('cloud_coverage') }}</div>
      <div class="legend-end">100&nbsp;%</div>
    </div>
  </div>

</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'CloudCoverageLegend',
  computed: {
    ...mapGetters(['showCloudCoverage'])
  }
}
</script>
