<template>
  <UserLayout>

    <template #title>{{ $t('security') }}</template>

    <template #content>
      <div class="card card-body">
        <h3 class="text-center">{{ $t('password') }}</h3>
        <UpdatePasswordForm/>
      </div>
    </template>

  </UserLayout>
</template>

<script>
import UpdatePasswordForm from '@scripts/components/form/UpdatePasswordForm'
import UserLayout from '@scripts/layouts/UserLayout'
import store from '@scripts/store'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'Security',
  components: {
    UpdatePasswordForm,
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
        this.setPageTitle(this.$t('security'))
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
      next({ name: 'sign_in', query: { target: 'user_security' } })
      return
    }

    next()
  }
}
</script>
