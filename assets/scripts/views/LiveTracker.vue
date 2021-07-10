<template>
  <LiveTrackerLayout>

    <template #content>
      <Map :latitude="latitude" :longitude="longitude" :rotation="rotation" :zoom="zoom" :force-show-aircrafts="true"
           @stateChanged="onStateChanged"/>
    </template>

  </LiveTrackerLayout>
</template>

<script>
import Map from '@scripts/components/Map'
import LiveTrackerLayout from '@scripts/layouts/LiveTrackerLayout'
import { mapActions } from 'vuex'

export default {
  name: 'LiveTracker',
  components: {
    LiveTrackerLayout,
    Map
  },
  methods: {
    ...mapActions([
      'setMetaDescription',
      'setMetaRobots',
      'setMetaTitle',
      'setMetaUrl',
      'setPageTitle'
    ]),
    onStateChanged (state) {
      this.$router.replace({
        ...this.$route,
        hash: `#map=${state.center[0]}/${state.center[1]}/${state.rotation}/${state.zoom}`
      })
    }
  },
  watch: {
    '$i18n.locale': {
      immediate: true,
      handler () {
        this.setMetaTitle(this.$t('live_tracker'))
        this.setPageTitle(this.$t('live_tracker'))
      }
    },
    '$route.hash': {
      immediate: true,
      handler (hash) {
        if (hash.startsWith('#map=')) {
          const parts = hash.replace('#map=', '').split('/')
          if (parts.length === 4) {
            this.latitude = parseFloat(parts[1])
            this.longitude = parseFloat(parts[0])
            this.rotation = parseFloat(parts[2])
            this.zoom = parseInt(parts[3], 10)
          }
        }
      }
    }
  },
  data () {
    return {
      latitude: 46.6061148,
      longitude: 1.8730891,
      rotation: 0,
      zoom: 6
    }
  },
  mounted () {
    this.setMetaDescription(null)
    this.setMetaRobots('index,follow,noarchive')
    this.setMetaUrl(null)
  }
}
</script>
