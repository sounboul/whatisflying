<template>
  <DefaultLayout>

    <template #content>
      <header class="card card-body">
        <slot name="header"/>
        <hr>
        <div class="d-flex justify-content-between">
          <a data-bs-toggle="collapse" href="#filtersCollapse" role="button"
             aria-controls="filtersCollapse" :aria-expanded="showFilters">
            {{ $t('filters') }}
            <FontAwesomeIcon class="align-middle ms-1" :icon="['far', showFilters ? 'angle-down' : 'angle-right']"
                             aria-hidden="true"/>
          </a>
        </div>
        <div class="collapse mt-3" :class="{ show: showFilters }" id="filtersCollapse">
          <slot name="filters"/>
        </div>
      </header>
      <div class="mt-3">
        <slot name="content"/>
      </div>
      <div class="mt-3">
        <slot name="pagination"/>
      </div>
    </template>

  </DefaultLayout>
</template>

<script>
import FontAwesomeIcon from '@scripts/fontawesome'
import DefaultLayout from '@scripts/layouts/DefaultLayout'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'AdminLayout',
  components: {
    DefaultLayout,
    FontAwesomeIcon
  },
  computed: {
    ...mapGetters(['showFilters'])
  },
  methods: {
    ...mapActions(['setShowFilters'])
  },
  mounted () {
    const filtersCollapse = document.getElementById('filtersCollapse')
    filtersCollapse.addEventListener('hidden.bs.collapse', () => {
      this.setShowFilters(false)
    })
    filtersCollapse.addEventListener('shown.bs.collapse', () => {
      this.setShowFilters(true)
    })
  }
}
</script>
