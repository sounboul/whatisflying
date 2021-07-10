<template>

  <div v-if="itemsLoaded">
    <i18n-t keypath="count.items" :plural="totalItems">
      <template #totalItems>
        <i18n-n tag="strong" :value="totalItems"/>
      </template>
    </i18n-t>

    <template v-if="totalItems">
      -
      <i18n-t keypath="count.pages">
        <template #currentPage>
          <i18n-n tag="strong" :value="currentPage"/>
        </template>
        <template #totalPages>
          <i18n-n tag="strong" :value="totalPages"/>
        </template>
      </i18n-t>
    </template>

  </div>
  <template v-else>
    <ContentLoader width="300" height="19.5">
      <rect x="0" y="3.5" width="300" height="16" rx="2" ry="2"/>
    </ContentLoader>
  </template>

</template>

<script>
import ContentLoader from '@scripts/components/ContentLoader'

export default {
  name: 'ListHeader',
  components: { ContentLoader },
  props: {
    items: Object,
    itemsLoaded: Boolean
  },
  computed: {
    currentPage () {
      return 'hydra:view' in this.items && '@id' in this.items['hydra:view']
        ? this.getPageNumber(this.items['hydra:view']['@id'])
        : 1
    },
    totalItems () {
      return 'hydra:totalItems' in this.items
        ? this.items['hydra:totalItems']
        : 1
    },
    totalPages () {
      return 'hydra:view' in this.items && 'hydra:last' in this.items['hydra:view']
        ? this.getPageNumber(this.items['hydra:view']['hydra:last'])
        : 1
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
