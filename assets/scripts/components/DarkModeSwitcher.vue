<template>
  <div class="d-flex align-items-center h-100" :class="{ 'text-light': darkMode }">
    <FontAwesomeIcon class="me-2" :icon="['fal', 'sun']" aria-hidden="true"/>
    <div class="form-check form-switch">
      <input class="form-check-input" type="checkbox" :aria-label="$t('toggle_dark_mode')"
             :checked="darkMode" @change="setDarkMode($event.target.checked)">
    </div>
    <FontAwesomeIcon class="ms-2" :icon="['fal', 'moon']" aria-hidden="true"/>
  </div>
</template>

<script>
import FontAwesomeIcon from '@scripts/fontawesome'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'DarkModeSwitcher',
  components: {
    FontAwesomeIcon
  },
  computed: {
    ...mapGetters(['darkMode'])
  },
  methods: {
    ...mapActions(['setDarkMode'])
  }
}
</script>
