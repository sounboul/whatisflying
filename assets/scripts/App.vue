<template>
  <teleport to="title">{{ pageTitle || $t('loading') }} - What is flying?</teleport>

  <teleport to="head">
    <link rel="canonical" :href="getAbsoluteUrl($route.path)">

    <meta name="description" :content="metaDescription">
    <meta name="robots" :content="metaRobots">

    <meta name="og:type" content="website">
    <meta name="og:url" :content="getAbsoluteUrl(metaUrl || '/')">
    <meta name="og:site_name" content="What is flying?">
    <meta name="og:title" :content="metaTitle || 'What is flying?'">
    <meta name="og:description" :content="metaDescription || $t('meta_description.default')">
    <meta name="og:locale" :content="$i18n.locale">

    <template v-for="locale in $i18n.availableLocales" :key="locale">
      <meta v-if="locale !== $i18n.locale" name="og:locale:alternate" :content="locale">
    </template>

    <template v-if="metaImages">
      <template v-for="metaImage in metaImages" :key="metaImage.key">
        <meta name="og:image:url" :content="metaImage.url">
        <meta name="og:image:type" :content="metaImage.type">
        <meta name="og:image:width" :content="metaImage.width">
        <meta name="og:image:height" :content="metaImage.height">
      </template>
    </template>
    <template v-else>
      <meta name="og:image:url" :content="getAbsoluteUrl(require('@images/og-banner.webp'))">
      <meta name="og:image:type" content="image/webp">
      <meta name="og:image:width" content="1200">
      <meta name="og:image:height" content="630">
    </template>

  </teleport>

  <RouterView :key="$route.path"/>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'App',
  computed: {
    ...mapGetters([
      'darkMode',
      'metaDescription',
      'metaImages',
      'metaRobots',
      'metaTitle',
      'metaUrl',
      'pageTitle',
      'user'
    ])
  },
  methods: {
    getAbsoluteUrl (path) {
      const url = new URL(path, process.env.BASE_URL)
      return url.toString()
    }
  },
  watch: {
    darkMode: {
      immediate: true,
      handler (darkMode) {
        const body = document.querySelector('body')
        body.setAttribute('data-theme', darkMode ? 'dark' : 'light')
      }
    },
    user: {
      immediate: true,
      handler (user) {
        if (user) {
          this.$i18n.locale = user.locale
        }
      }
    }
  }
}
</script>
