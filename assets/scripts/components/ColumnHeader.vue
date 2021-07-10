<template>
  <div class="w-100 d-flex align-items-center">
    <a href="#" @click.prevent="$emit('update:modelValue', modelValue === 'asc' ? 'desc' : 'asc')"
       :title="modelValue === 'asc' ? $t('sort_by_descending_order') : $t('sort_by_ascending_order')">
      <slot/>
    </a>
    <div class="d-flex align-items-center ms-3">
      <a href="#" :class="{ 'text-muted': modelValue === 'asc' }" @click.prevent="$emit('update:modelValue', 'asc')">
        <span class="visually-hidden">{{ $t('sort_by_ascending_order') }}</span>
        <span data-bs-toggle="tooltip" :title="$t('sort_by_ascending_order')">
          <FontAwesomeIcon class="me-1" :icon="['far', 'angle-up']" aria-hidden="true"/>
        </span>
      </a>
      <a href="#" :class="{ 'text-muted': modelValue === 'desc' }" @click.prevent="$emit('update:modelValue', 'desc')">
        <span class="visually-hidden">{{ $t('sort_by_descending_order') }}</span>
        <span data-bs-toggle="tooltip" :title="$t('sort_by_descending_order')">
          <FontAwesomeIcon :icon="['far', 'angle-down']" aria-hidden="true"/>
        </span>
      </a>

      <a v-if="modelValue" href="#" class="text-danger" @click.prevent="$emit('update:modelValue', null)">
        <span class="visually-hidden">{{ $t('restore_default_sort_order') }}</span>
        <span data-bs-toggle="tooltip" :title="$t('restore_default_sort_order')">
          <FontAwesomeIcon class="ms-3" :icon="['far', 'trash']" aria-hidden="true"/>
        </span>
      </a>

    </div>
  </div>
</template>

<script>
import FontAwesomeIcon from '@scripts/fontawesome'

export default {
  name: 'ColumnHeader',
  components: { FontAwesomeIcon },
  props: {
    modelValue: String
  }
}
</script>
