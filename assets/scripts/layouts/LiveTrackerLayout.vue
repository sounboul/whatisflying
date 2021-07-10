<template>
  <DefaultLayout>

    <template #container>
      <slot name="content"/>
    </template>

  </DefaultLayout>
</template>

<script>
import DefaultLayout from '@scripts/layouts/DefaultLayout'

export default {
  name: 'LiveTrackerLayout',
  components: {
    DefaultLayout
  }
}
</script>
