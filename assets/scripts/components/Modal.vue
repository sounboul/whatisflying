<template>
  <div class="modal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">
            <slot name="title"/>
          </h3>
          <button type="button" class="btn-close" :class="{ 'btn-close-white': darkMode }"
                  data-bs-dismiss="modal" :aria-label="$t('close')"></button>
        </div>
        <div class="modal-body">
          <slot name="body"/>
        </div>
        <div class="modal-footer">
          <slot name="footer"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'Modal',
  computed: {
    ...mapGetters(['darkMode'])
  }
}
</script>
