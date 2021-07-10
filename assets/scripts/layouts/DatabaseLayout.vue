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
          <div class="nav" role="tablist">
            <a class="nav-item nav-link" :class="{ active: displayMode === 'grid' }"
               id="displayGridTab" href="#displayGrid" data-bs-toggle="tab" role="tab"
               aria-controls="displayGrid" :aria-selected="displayMode === 'grid'">
              <span class="visually-hidden">{{ $t('show_as_grid') }}</span>
              <span data-bs-toggle="tooltip" :title="$t('show_as_grid')">
                <FontAwesomeIcon :icon="['fal', 'table-cells']" aria-hidden="true"/>
              </span>
            </a>
            <a class="nav-item nav-link" :class="{ active: displayMode === 'list' }"
               id="displayListTab" href="#displayList" data-bs-toggle="tab" role="tab"
               aria-controls="displayList" :aria-selected="displayMode === 'list'">
              <span class="visually-hidden">{{ $t('show_as_list') }}</span>
              <span data-bs-toggle="tooltip" :title="$t('show_as_list')">
                <FontAwesomeIcon :icon="['fal', 'table-list']" aria-hidden="true"/>
              </span>
            </a>
          </div>
        </div>
        <div class="collapse mt-3" :class="{ show: showFilters }" id="filtersCollapse">
          <slot name="filters"/>
        </div>
      </header>
      <div class="tab-content mt-3">
        <div class="tab-pane fade" :class="{ active: displayMode === 'grid', show: displayMode === 'grid' }"
             id="displayGrid" role="tabpanel" aria-labelledby="displayGridTab">
          <div class="card card-body mb-3">
            <a data-bs-toggle="collapse" href="#sortCollapse" role="button"
               aria-controls="sortCollapse" :aria-expanded="showSort">
              {{ $t('sort') }}
              <FontAwesomeIcon class="align-middle ms-1" :icon="['far', showSort ? 'angle-down' : 'angle-right']"
                               aria-hidden="true"/>
            </a>
            <div class="collapse mt-3" :class="{ show: showSort }" id="sortCollapse">
              <slot name="sort"/>
            </div>
          </div>
          <slot name="gridView"/>
        </div>
        <div class="tab-pane fade" :class="{ active: displayMode === 'list', show: displayMode === 'list' }"
             id="displayList" role="tabpanel" aria-labelledby="displayListTab">
          <slot name="listView"/>
        </div>
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
  name: 'DatabaseLayout',
  components: {
    DefaultLayout,
    FontAwesomeIcon
  },
  computed: {
    ...mapGetters([
      'displayMode',
      'showFilters',
      'showSort'
    ])
  },
  methods: {
    ...mapActions([
      'setDisplayMode',
      'setShowFilters',
      'setShowSort'
    ])
  },
  mounted () {
    const filtersCollapse = document.getElementById('filtersCollapse')
    filtersCollapse.addEventListener('hidden.bs.collapse', () => {
      this.setShowFilters(false)
    })
    filtersCollapse.addEventListener('shown.bs.collapse', () => {
      this.setShowFilters(true)
    })

    const sortCollapse = document.getElementById('sortCollapse')
    sortCollapse.addEventListener('hidden.bs.collapse', () => {
      this.setShowSort(false)
    })
    sortCollapse.addEventListener('shown.bs.collapse', () => {
      this.setShowSort(true)
    })

    const displayGridTab = document.getElementById('displayGridTab')
    displayGridTab.addEventListener('shown.bs.tab', () => {
      this.setDisplayMode('grid')
    })

    const displayListTab = document.getElementById('displayListTab')
    displayListTab.addEventListener('shown.bs.tab', () => {
      this.setDisplayMode('list')
    })
  }
}
</script>
