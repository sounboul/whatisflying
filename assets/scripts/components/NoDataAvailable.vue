<template>
  <div class="text-center text-muted">
    <FontAwesomeIcon :icon="['fal','face-sad-tear']" size="3x" aria-hidden="true"/>
    <div class="h3 mt-2 text-muted">
      {{ $t('no_data_available') }}
    </div>
  </div>
</template>

<script>
import FontAwesomeIcon from '@scripts/fontawesome'

export default {
  name: 'NoDataAvailable',
  components: { FontAwesomeIcon }
}
</script>
