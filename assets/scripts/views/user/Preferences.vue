<template>
  <UserLayout>

    <template #title>{{ $t('preferences') }}</template>

    <template #content>
      <div class="card card-body">
        <h3 class="text-center">{{ $t('locale') }}</h3>
        <UpdateLocaleForm/>
      </div>
    </template>

  </UserLayout>
</template>

<script>
import UpdateLocaleForm from '@scripts/components/form/UpdateLocaleForm'
import UserLayout from '@scripts/layouts/UserLayout'
import store from '@scripts/store'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'Preferences',
  components: {
    UpdateLocaleForm,
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
        this.setPageTitle(this.$t('preferences'))
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
      next({ name: 'sign_in', query: { target: 'user_preferences' } })
      return
    }

    next()
  }
}
</script>
