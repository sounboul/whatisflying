<template>
  <img :src="src" :width="width" :height="height" alt="">
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'StaticMap',
  props: {
    height: String,
    params: Object,
    width: String
  },
  computed: {
    ...mapGetters(['locale']),
    src () {
      const languages = {
        en: 'eng',
        fr: 'fre'
      }

      const defaults = {
        apiKey: process.env.HERE_API_KEY,
        h: this.height,
        lc: '0085ad',
        ml: languages[this.locale],
        nocp: true,
        nocrop: true,
        sc: '005587',
        t: 0,
        w: this.width
      }

      const params = {
        ...defaults,
        ...this.params
      }

      const url = new URL('/mia/1.6/route', 'https://image.maps.ls.hereapi.com')

      Object.keys(params).forEach(param => {
        url.searchParams.set(param, String(params[param]))
      })

      return url.toString()
    }
  }
}
</script>
