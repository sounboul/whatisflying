<template>
  <svg xmlns="http://www.w3.org/2000/svg" :viewBox="`0 0 ${width} ${height}`" :width="width" :height="height">
    <rect x="0" y="0" :width="width" :height="height"
          :clip-path="`url(#clipPath${uuid})`" :style="{ fill: `url(#gradient${uuid})` }"/>
    <defs>
      <clipPath :id="`clipPath${uuid}`">
        <slot>
          <rect x="0" y="0" rx="2" ry="2" width="100%" height="100%"/>
        </slot>
      </clipPath>
      <linearGradient :id="`gradient${uuid}`">
        <stop offset="0%" :stop-color="darkMode ? '#474b4f' : '#f6f8fa'" stop-opacity="1.0">
          <animate attributeName="offset" values="-2; 1" dur="1.5s" repeatCount="indefinite"/>
        </stop>
        <stop offset="50%" :stop-color="darkMode ? '#606468' : '#dddfe2'" stop-opacity="1.0">
          <animate attributeName="offset" values="-1.5; 1.5" dur="1.5s" repeatCount="indefinite"/>
        </stop>
        <stop offset="100%" :stop-color="darkMode ? '#474b4f' : '#f6f8fa'" stop-opacity="1.0">
          <animate attributeName="offset" values="-1; 2" dur="1.5s" repeatCount="indefinite"/>
        </stop>
      </linearGradient>
    </defs>
  </svg>
</template>

<script>
import * as uuid from 'uuid'
import { mapGetters } from 'vuex'

export default {
  name: 'ContentLoader',
  props: {
    height: String,
    width: String
  },
  computed: {
    ...mapGetters(['darkMode'])
  },
  data () {
    return {
      uuid: uuid.v4()
    }
  }
}
</script>
