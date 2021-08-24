<template>
  <DefaultLayout>

    <template #container>
      <header class="header">
        <div class="header-background" :style="{ backgroundImage: `url(${backgroundImage})` }"></div>
        <h1 class="display-1 text-center text-light">
          <slot name="title"/>
        </h1>
      </header>
      <div class="container py-3" :style="{ maxWidth }">
        <slot name="content"/>
      </div>
    </template>

  </DefaultLayout>
</template>

<script>
import DefaultLayout from '@scripts/layouts/DefaultLayout'
import Math from '@scripts/mathjs'

export default {
  name: 'CenteredLayout',
  components: {
    DefaultLayout
  },
  props: {
    maxWidth: {
      default: 'auto',
      type: String
    }
  },
  computed: {
    backgroundImage () {
      return require(`@images/header/${Math.randomInt(1, 8)}.webp`)
    }
  }
}
</script>
