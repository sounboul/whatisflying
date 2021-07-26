<template>
  <div class="map-layout">
    <slot name="map"/>
    <div class="map-search">
      <slot name="search"/>
    </div>
    <div class="map-controls">
      <slot name="controls"/>
    </div>
    <div class="map-overlay" data-id="overlay">
      <slot name="overlay"/>
    </div>
    <div class="map-legend">
      <slot name="legend"/>
    </div>
  </div>
</template>

<script>
import SimpleBar from 'simplebar'

export default {
  name: 'MapLayout',
  methods: {
    setupScrollbar () {
      this.scrollbar = new SimpleBar(document.querySelector('[data-id="overlay"]'))
    }
  },
  data () {
    return {
      scrollbar: null
    }
  },
  mounted () {
    this.setupScrollbar()
  }
}
</script>
