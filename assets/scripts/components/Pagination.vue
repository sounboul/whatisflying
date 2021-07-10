<template>

  <ul v-if="itemsLoaded" class="pagination justify-content-center mt-3 mb-0">
    <li class="page-item" :class="{ disabled: currentPage === firstPage }">
      <a class="page-link" href="#" @click.prevent="$emit('update:modelValue', firstPage)">
        <span class="visually-hidden">{{ $t('first_page') }}</span>
        <FontAwesomeIcon :icon="['far','angles-left']" aria-hidden="true"/>
      </a>
    </li>
    <li class="page-item" :class="{ disabled: !previousPage }">
      <a class="page-link" href="#" @click.prevent="$emit('update:modelValue', previousPage)">
        <span class="visually-hidden">{{ $t('previous_page') }}</span>
        <FontAwesomeIcon :icon="['far','angle-left']" aria-hidden="true"/>
      </a>
    </li>
    <template v-for="page in $m.range(firstPage, lastPage, true).toArray()" :key="page">

      <li v-if="currentPage === page" class="page-item active">
        <a class="page-link" href="#" aria-current="true" @click.prevent="$emit('update:modelValue', page)">
          <span class="visually-hidden">{{ $t('current_page') }}</span>
          {{ page }}
        </a>
      </li>
      <li v-else-if="currentPage - nearbyPages - page < 0 && currentPage + nearbyPages - page > 0"
          class="page-item d-none d-md-inline-block">
        <a class="page-link" href="#" @click.prevent="$emit('update:modelValue', page)">
          {{ page }}
        </a>
      </li>
      <li v-else-if="currentPage - nearbyPages - page === 0 || currentPage + nearbyPages - page === 0"
          class="page-item d-none d-md-inline-block disabled">
        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
          <FontAwesomeIcon :icon="['far','ellipsis']" aria-hidden="true"/>
        </a>
      </li>

    </template>
    <li class="page-item" :class="{ disabled: !nextPage }">
      <a class="page-link" href="#" @click.prevent="$emit('update:modelValue', nextPage)">
        <span class="visually-hidden">{{ $t('next_page') }}</span>
        <FontAwesomeIcon :icon="['far','angle-right']" aria-hidden="true"/>
      </a>
    </li>
    <li class="page-item" :class="{ disabled: currentPage === lastPage }">
      <a class="page-link" href="#" @click.prevent="$emit('update:modelValue', lastPage)">
        <span class="visually-hidden">{{ $t('last_page') }}</span>
        <FontAwesomeIcon :icon="['far','angles-right']" aria-hidden="true"/>
      </a>
    </li>
  </ul>

  <div v-else class="d-flex justify-content-center">
    <ContentLoader width="300" height="33.5">
      <rect x="0" y="0" width="300" height="33.5" rx="8" ry="8"/>
    </ContentLoader>
  </div>

</template>

<script>
import ContentLoader from '@scripts/components/ContentLoader'
import FontAwesomeIcon from '@scripts/fontawesome'

export default {
  name: 'Pagination',
  components: {
    ContentLoader,
    FontAwesomeIcon
  },
  props: {
    items: Object,
    itemsLoaded: Boolean,
    modelValue: [Number, String],
    nearbyPages: {
      default: 4,
      type: Number
    }
  },
  computed: {
    currentPage () {
      return Number(this.modelValue)
    },
    firstPage () {
      return 'hydra:view' in this.items && 'hydra:first' in this.items['hydra:view']
        ? this.getPageNumber(this.items['hydra:view']['hydra:first'])
        : 1
    },
    lastPage () {
      return 'hydra:view' in this.items && 'hydra:last' in this.items['hydra:view']
        ? this.getPageNumber(this.items['hydra:view']['hydra:last'])
        : 1
    },
    nextPage () {
      return 'hydra:view' in this.items && 'hydra:next' in this.items['hydra:view']
        ? this.getPageNumber(this.items['hydra:view']['hydra:next'])
        : null
    },
    previousPage () {
      return 'hydra:view' in this.items && 'hydra:previous' in this.items['hydra:view']
        ? this.getPageNumber(this.items['hydra:view']['hydra:previous'])
        : null
    }
  },
  methods: {
    getPageNumber (path) {
      const url = new URL(path, process.env.BASE_URL)
      return Number(url.searchParams.get('page') || 1)
    }
  }
}
</script>
