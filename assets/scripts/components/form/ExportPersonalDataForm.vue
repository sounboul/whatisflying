<template>
  <form class="row g-3">
    <div class="col-12 text-center">
      <button class="btn btn-outline-primary" type="button" :disabled="disabled" @click="submit">
        {{ $t('export_personal_data') }}
      </button>
    </div>
  </form>
</template>

<script>
import { User } from '@scripts/services/api'

export default {
  name: 'ExportPersonalDataForm',
  methods: {
    submit () {
      this.disabled = true
      this.violations = {}

      User.getCurrentUser().then(user => {
        const link = document.createElement('a')
        link.setAttribute('href', 'data:application/json;charset=utf-8,' + encodeURIComponent(JSON.stringify(user)))
        link.setAttribute('download', 'user.json')
        link.click()
      }).finally(() => {
        this.disabled = false
      })
    }
  },
  data () {
    return {
      data: {},
      disabled: false,
      violations: {}
    }
  }
}
</script>
