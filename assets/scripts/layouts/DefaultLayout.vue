<template>
  <Navbar/>
  <main class="content">
    <slot name="container">
      <div class="container-fluid py-3">
        <slot name="content"/>
      </div>
    </slot>
  </main>
  <Footer/>
</template>

<script>
import Footer from '@scripts/components/Footer'
import Navbar from '@scripts/components/Navbar'

export default {
  name: 'DefaultLayout',
  components: {
    Footer,
    Navbar
  }
}
</script>
