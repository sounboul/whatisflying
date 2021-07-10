<template>
  <UserLayout>

    <template #title>{{ $t('privacy') }}</template>

    <template #content>
      <div class="card card-body">
        <h3 class="text-center">{{ $t('export_personal_data') }}</h3>
        <ExportPersonalDataForm/>
      </div>
      <div class="card card-body mt-3">
        <h3 class="text-center">{{ $t('delete_account') }}</h3>
        <div class="alert alert-warning">
          <div class="d-flex align-items-center">
            <FontAwesomeIcon class="me-3" :icon="['far', 'triangle-exclamation']" size="3x" aria-hidden="true"/>
            {{ $t('account_deletion_is_immediate_and_definitive') }}
          </div>
        </div>
        <DeleteAccountForm/>
      </div>
    </template>

  </UserLayout>
</template>

<script>
import DeleteAccountForm from '@scripts/components/form/DeleteAccountForm'
import ExportPersonalDataForm from '@scripts/components/form/ExportPersonalDataForm'
import FontAwesomeIcon from '@scripts/fontawesome'
import UserLayout from '@scripts/layouts/UserLayout'
import store from '@scripts/store'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'Privacy',
  components: {
    DeleteAccountForm,
    ExportPersonalDataForm,
    FontAwesomeIcon,
    UserLayout
  },
  computed: {
    ...mapGetters(['user'])
  },
  methods: {
    ...mapActions(['setPageTitle'])
  },
  watch: {
    '$i18n.locale': {
      immediate: true,
      handler () {
        this.setPageTitle(this.$t('privacy'))
      }
    },
    user (user) {
      if (!user) {
        this.$router.replace({ name: 'live_tracker' })
      }
    }
  },
  beforeRouteEnter (to, from, next) {
    if (!store.getters.user) {
      next({ name: 'sign_in', query: { target: 'user_privacy' } })
      return
    }

    next()
  }
}
</script>
