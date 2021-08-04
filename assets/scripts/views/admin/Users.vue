<template>
  <AdminLayout>

    <template #header>
      <h1 class="card-title">{{ $t('users') }}</h1>
      <ListHeader :items="users" :items-loaded="usersLoaded"/>
    </template>

    <template #filters>
      <div class="row g-3">
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterEmail">{{ $t('label.email') }}</label>
          <input class="form-control" id="filterEmail" type="text"
                 :placeholder="$t('enter_an_email_address')" v-model="filters.email">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterUsername">{{ $t('label.username') }}</label>
          <input class="form-control" id="filterUsername" type="text"
                 :placeholder="$t('enter_a_username')" v-model="filters.username">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterEnabled">{{ $t('label.enabled__m') }}</label>
          <BooleanSelect id="filterEnabled" v-model="filters.enabled"/>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <label class="form-label" for="filterLocked">{{ $t('label.locked__m') }}</label>
          <BooleanSelect id="filterLocked" v-model="filters.locked"/>
        </div>
      </div>
      <div class="d-flex justify-content-center mt-5">
        <button class="btn btn-outline-primary" type="button" @click="resetFilters">
          {{ $t('reset_filters') }}
        </button>
      </div>
    </template>

    <template #content>
      <!-- @bug: Workaround for bug https://github.com/vuejs/vue-next/issues/3569 -->
      <div class="card card-body" :key="1">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead>
              <tr>
                <th scope="col" class="col-2">
                  <ColumnHeader v-model="order.email">
                    {{ $t('email') }}
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-2">
                  <ColumnHeader v-model="order.username">
                    {{ $t('username') }}
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-1">
                  <ColumnHeader v-model="order.enabled">
                    {{ $t('enabled__m') }}
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-1">
                  <ColumnHeader v-model="order.locked">
                    {{ $t('locked__m') }}
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-2">
                  <ColumnHeader v-model="order.created">
                    {{ $t('created__m') }}
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-2">
                  <ColumnHeader v-model="order.updated">
                    {{ $t('updated__m') }}
                  </ColumnHeader>
                </th>
                <th scope="col" class="col-2">
                  {{ $t('actions') }}
                </th>
              </tr>
            </thead>
            <tbody>

              <template v-if="usersLoaded">
                <tr v-for="_user in users['hydra:member']" :key="_user.id">
                  <td>{{ _user.email }}</td>
                  <td>{{ _user.username }}</td>
                  <td>

                    <strong v-if="_user.enabled" class="text-success">{{ $t('yes') }}</strong>
                    <strong v-else class="text-danger">{{ $t('no') }}</strong>

                  </td>
                  <td>

                    <strong v-if="_user.locked" class="text-danger">{{ $t('yes') }}</strong>
                    <strong v-else class="text-success">{{ $t('no') }}</strong>

                  </td>
                  <td>
                    {{ $dt.fromISO(_user.created).setLocale($i18n.locale).toLocaleString($dt.DATETIME_MED) }}
                  </td>
                  <td>

                    <template v-if="_user.updated">
                      {{ $dt.fromISO(_user.updated).setLocale($i18n.locale).toLocaleString($dt.DATETIME_MED) }}
                    </template>
                    <template v-else>
                      -
                    </template>

                  </td>
                  <td>

                    <button v-if="_user.locked && _user.id !== user?.id" class="btn btn-sm btn-outline-success me-1"
                            data-bs-toggle="modal" :data-bs-target="`#unlock${_user.id}`">
                      <FontAwesomeIcon :icon="['far', 'lock-open']" fixed-width aria-hidden="true"/>
                    </button>
                    <button v-else-if="_user.id !== user?.id" class="btn btn-sm btn-outline-danger me-1"
                            data-bs-toggle="modal" :data-bs-target="`#lock${_user.id}`">
                      <FontAwesomeIcon :icon="['far', 'lock']" fixed-width aria-hidden="true"/>
                    </button>

                  </td>
                </tr>
              </template>

              <template v-else>
                <tr v-for="index in $m.range(0, 24).toArray()" :key="index">
                  <td>
                    <ContentLoader width="200" height="15"/>
                  </td>
                  <td>
                    <ContentLoader width="200" height="15"/>
                  </td>
                  <td>
                    <ContentLoader width="100" height="15"/>
                  </td>
                  <td>
                    <ContentLoader width="100" height="15"/>
                  </td>
                  <td>
                    <ContentLoader width="200" height="15"/>
                  </td>
                  <td>
                    <ContentLoader width="200" height="15"/>
                  </td>
                  <td>
                    <ContentLoader width="26" height="26" rx="2" ry="2"/>
                  </td>
                </tr>
              </template>

            </tbody>
          </table>
        </div>
      </div>
    </template>

    <template #pagination>
      <Pagination :items="users" :items-loaded="usersLoaded" v-model="page"/>
    </template>

  </AdminLayout>

  <teleport to="body">

    <template v-if="usersLoaded">
      <template v-for="_user in users['hydra:member']" :key="_user.id">

        <Modal v-if="!_user.locked && _user.id !== user?.id" :id="`lock${_user.id}`">

          <template #title>
            {{ $t('lock_account') }}
          </template>

          <template #body>
            <i18n-t keypath="are_you_sure_you_want_to_lock_user_account">
              <template #username>
                <strong>{{ _user.username }}</strong>
              </template>
            </i18n-t>
          </template>

          <template #footer>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              {{ $t('cancel') }}
            </button>
            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"
                    @click="lockAccount(_user.id)">
              {{ $t('lock_account') }}
            </button>
          </template>

        </Modal>

        <Modal v-if="_user.locked && _user.id !== user?.id" :id="`unlock${_user.id}`">

          <template #title>
            {{ $t('unlock_account') }}
          </template>

          <template #body>
            <i18n-t keypath="are_you_sure_you_want_to_unlock_user_account">
              <template #username>
                <strong>{{ _user.username }}</strong>
              </template>
            </i18n-t>
          </template>

          <template #footer>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              {{ $t('cancel') }}
            </button>
            <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal"
                    @click="unlockAccount(_user.id)">
              {{ $t('unlock_account') }}
            </button>
          </template>

        </Modal>

      </template>
    </template>

  </teleport>

</template>

<script>

import ColumnHeader from '@scripts/components/ColumnHeader'
import ContentLoader from '@scripts/components/ContentLoader'
import BooleanSelect from '@scripts/components/form/fields/BooleanSelect'
import ListHeader from '@scripts/components/ListHeader'
import Modal from '@scripts/components/Modal'
import Pagination from '@scripts/components/Pagination'
import FontAwesomeIcon from '@scripts/fontawesome'
import AdminLayout from '@scripts/layouts/AdminLayout'
import User from '@scripts/services/api/data/user'
import store from '@scripts/store'
import { CancelToken } from 'axios'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'Users',
  components: {
    AdminLayout,
    BooleanSelect,
    ContentLoader,
    ColumnHeader,
    FontAwesomeIcon,
    ListHeader,
    Modal,
    Pagination
  },
  computed: {
    ...mapGetters(['user'])
  },
  methods: {
    ...mapActions(['setPageTitle']),
    loadUsers () {
      this.cancelToken?.cancel('Concurrent request')
      this.cancelToken = CancelToken.source()
      this.usersLoaded = false

      User.getUsers({
        cancelToken: this.cancelToken.token,
        params: {
          ...this.filters,
          order: this.order,
          page: this.page,
          properties: {
            ...['id', 'created', 'email', 'enabled', 'locked', 'updated', 'username']
          }
        }
      }).then(users => {
        this.users = users
        this.usersLoaded = true
      })
    },
    lockAccount (id) {
      this.disabled = true

      User.lockAccount(id).then(() => {
        this.loadUsers()
      }).finally(() => {
        this.disabled = false
      })
    },
    parseQuery (query = {}) {
      const {
        email = null,
        enabled = null,
        locked = null,
        username = null,
        order = {},
        page = 1
      } = query

      this.filters = {
        email,
        enabled,
        locked,
        username
      }

      this.order = { ...order }
      this.page = page
    },
    resetFilters () {
      this.filters = {}
      this.page = 1
    },
    unlockAccount (id) {
      this.disabled = true

      User.unlockAccount(id).then(() => {
        this.loadUsers()
      }).finally(() => {
        this.disabled = false
      })
    }
  },
  watch: {
    '$i18n.locale': {
      immediate: true,
      handler () {
        this.setPageTitle(this.$t('users'))
      }
    },
    '$route.query': {
      deep: true,
      immediate: true,
      handler (query) {
        if (this.$route.name === 'admin_users') {
          this.parseQuery(query)
          this.loadUsers()
        }
      }
    },
    filters: {
      deep: true,
      handler (filters, oldFilters) {
        if (filters === oldFilters) {
          this.page = 1
        }

        this.$router.replace({
          name: 'admin_users',
          query: {
            ...filters,
            order: this.order,
            page: this.page
          }
        })
      }
    },
    order: {
      deep: true,
      handler (order) {
        this.$router.replace({
          name: 'admin_users',
          query: {
            ...this.filters,
            order,
            page: this.page
          }
        })
      }
    },
    page (page) {
      this.$router.push({
        name: 'admin_users',
        query: {
          ...this.filters,
          order: this.order,
          page
        }
      })
    },
    user (user) {
      if (!user) {
        this.$router.replace({ name: 'live_tracker' })
      }
    }
  },
  data () {
    return {
      cancelToken: null,
      disabled: false,
      filters: {},
      order: {},
      page: 1,
      users: null,
      usersLoaded: false
    }
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  },
  beforeRouteEnter (to, from, next) {
    if (!store.getters.user || !store.getters.user.roles.includes('ROLE_ADMIN')) {
      next({ name: 'live_tracker' })
      return
    }

    next()
  }
}
</script>
