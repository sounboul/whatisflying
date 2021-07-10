<template>
  <nav class="navbar navbar-expand-lg sticky-top shadow" :class="navbarClass">
    <div class="container-fluid">
      <RouterLink class="navbar-brand" :to="{ name: 'live_tracker' }">
        <img class="d-inline-block me-2" src="@images/logo.svg"
             width="40" height="40" alt=""> What is flying?
      </RouterLink>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas"
              aria-controls="offcanvas" aria-expanded="false" :aria-label="$t('show_navigation_menu')">
        <FontAwesomeIcon :icon="['far', 'bars']" aria-hidden="true"/>
      </button>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <RouterLink class="nav-link" active-class="active" :to="{ name: 'live_tracker' }" exact>
              {{ $t('live_tracker') }}
            </RouterLink>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="databaseDropdown" href="#" role="button"
               data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
              {{ $t('database') }}
            </a>
            <div class="dropdown-menu" :class="{ 'dropdown-menu-dark': darkMode }" aria-labelledby="databaseDropdown">
              <RouterLink class="dropdown-item" active-class="active" :to="{ name: 'database_aircrafts' }" exact>
                {{ $t('aircraft__p') }}
              </RouterLink>
              <RouterLink class="dropdown-item" active-class="active" :to="{ name: 'database_aircraft_types' }" exact>
                {{ $t('aircraft_types') }}
              </RouterLink>
              <RouterLink class="dropdown-item" active-class="active" :to="{ name: 'database_airlines' }" exact>
                {{ $t('airlines') }}
              </RouterLink>
              <RouterLink class="dropdown-item" active-class="active" :to="{ name: 'database_airports' }" exact>
                {{ $t('airports') }}
              </RouterLink>
              <RouterLink class="dropdown-item" active-class="active" :to="{ name: 'database_flights' }" exact>
                {{ $t('flights') }}
              </RouterLink>
              <RouterLink class="dropdown-item" active-class="active" :to="{ name: 'database_navaids' }" exact>
                {{ $t('navaids') }}
              </RouterLink>
            </div>
          </li>

          <li v-if="user && user.roles.includes('ROLE_ADMIN')" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="adminDropdown" href="#" role="button"
               data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
              {{ $t('admin') }}
            </a>
            <div class="dropdown-menu" :class="{ 'dropdown-menu-dark': darkMode }" aria-labelledby="adminDropdown">
              <RouterLink class="dropdown-item" active-class="active" :to="{ name: 'admin_users' }" exact>
                {{ $t('users') }}
              </RouterLink>
            </div>
          </li>

        </ul>
        <ul class="navbar-nav">

          <li v-if="user" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button"
               data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
              <i18n-t keypath="welcome">
                <template #username>
                  <strong>{{ user.username }}</strong>
                </template>
              </i18n-t>
            </a>
            <div class="dropdown-menu dropdown-menu-end" :class="{ 'dropdown-menu-dark': darkMode }"
                 aria-labelledby="userDropdown">
              <RouterLink class="dropdown-item" active-class="active" :to="{ name: 'user_preferences' }" exact>
                {{ $t('preferences') }}
              </RouterLink>
              <RouterLink class="dropdown-item" active-class="active" :to="{ name: 'user_security' }" exact>
                {{ $t('security') }}
              </RouterLink>
              <RouterLink class="dropdown-item" active-class="active" :to="{ name: 'user_privacy' }" exact>
                {{ $t('privacy') }}
              </RouterLink>
              <hr class="dropdown-divider">
              <a class="dropdown-item" href="#" role="button" @click="logout">
                {{ $t('sign_out') }}
              </a>
            </div>
          </li>

          <template v-else>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="signInDropdown" href="#" role="button"
                 data-bs-auto-close="false" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                {{ $t('sign_in') }}
              </a>
              <div class="dropdown-menu dropdown-menu-end p-3" :class="{ 'dropdown-menu-dark': darkMode }"
                   :style="{ minWidth: '300px' }" aria-labelledby="signInDropdown">
                <h3 class="text-center">{{ $t('sign_in') }}</h3>
                <SignInForm/>
              </div>
            </li>
            <li class="nav-item">
              <RouterLink class="nav-link" active-class="active" :to="{ name: 'sign_up' }" exact>
                {{ $t('sign_up') }}
              </RouterLink>
            </li>
          </template>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="localeDropdown" href="#" role="button"
               data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">

              <template v-if="$i18n.locale === 'fr'">
                <CountryFlag class="me-2" country-code="FR" height="16"/>
              </template>
              <template v-else>
                <CountryFlag class="me-2" country-code="GB" height="16"/>
              </template>

            </a>
            <div class="dropdown-menu dropdown-menu-end" :class="{ 'dropdown-menu-dark': darkMode }"
                 aria-labelledby="localeDropdown">
              <a class="dropdown-item" href="#" @click.prevent="setLocale('fr')">
                <CountryFlag class="me-2" country-code="FR" height="16"/>
                {{ $t('french') }}
              </a>
              <a class="dropdown-item" href="#" @click.prevent="setLocale('en')">
                <CountryFlag class="me-2" country-code="GB" height="16"/>
                {{ $t('english') }}
              </a>
            </div>
          </li>
          <li class="nav-item">
            <DarkModeSwitcher class="ms-2"/>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="offcanvas offcanvas-start" id="offcanvas" tabindex="-1">
    <div class="offcanvas-header">
      <button type="button" class="btn-close text-reset" :class="{ 'btn-close-white': darkMode }"
              data-bs-dismiss="offcanvas" :aria-label="$t('hide_navigation_menu')"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="nav flex-column">
        <li class="nav-item">
          <RouterLink class="nav-link" active-class="active" :to="{ name: 'live_tracker' }" exact>
            {{ $t('live_tracker') }}
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink class="nav-link" active-class="active" :to="{ name: 'database_aircrafts' }" exact>
            {{ $t('aircraft__p') }}
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink class="nav-link" active-class="active" :to="{ name: 'database_aircraft_types' }" exact>
            {{ $t('aircraft_types') }}
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink class="nav-link" active-class="active" :to="{ name: 'database_airlines' }" exact>
            {{ $t('airlines') }}
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink class="nav-link" active-class="active" :to="{ name: 'database_airports' }" exact>
            {{ $t('airports') }}
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink class="nav-link" active-class="active" :to="{ name: 'database_flights' }" exact>
            {{ $t('flights') }}
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink class="nav-link" active-class="active" :to="{ name: 'database_navaids' }" exact>
            {{ $t('navaids') }}
          </RouterLink>
        </li>
      </ul>
      <hr>
      <ul class="nav flex-column">

        <template v-if="user">
          <li class="nav-item">
            <RouterLink class="nav-link" active-class="active" :to="{ name: 'user_preferences' }" exact>
              {{ $t('preferences') }}
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" active-class="active" :to="{ name: 'user_security' }" exact>
              {{ $t('security') }}
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" active-class="active" :to="{ name: 'user_privacy' }" exact>
              {{ $t('privacy') }}
            </RouterLink>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" role="button" @click="logout">
              {{ $t('sign_out') }}
            </a>
          </li>
        </template>

        <template v-else>
          <li class="nav-item">
            <RouterLink class="nav-link" active-class="active" :to="{ name: 'sign_in' }" exact>
              {{ $t('sign_in') }}
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" active-class="active" :to="{ name: 'sign_up' }" exact>
              {{ $t('sign_up') }}
            </RouterLink>
          </li>
        </template>

      </ul>
      <hr>
      <ul class="nav justify-content-between">
        <li class="nav-item dropdown">
          <a class="dropdown-toggle" id="localeDropdown2" href="#" role="button"
             data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">

            <template v-if="$i18n.locale === 'fr'">
              <CountryFlag class="me-2" country-code="FR" height="16"/>
            </template>
            <template v-else>
              <CountryFlag class="me-2" country-code="GB" height="16"/>
            </template>

          </a>
          <div class="dropdown-menu" :class="{ 'dropdown-menu-dark': darkMode }"
               aria-labelledby="localeDropdown2">
            <a class="dropdown-item" href="#" @click.prevent="setLocale('fr')">
              <CountryFlag class="me-2" country-code="FR" height="16"/>
              {{ $t('french') }}
            </a>
            <a class="dropdown-item" href="#" @click.prevent="setLocale('en')">
              <CountryFlag class="me-2" country-code="GB" height="16"/>
              {{ $t('english') }}
            </a>
          </div>
        </li>
        <li class="nav-item">
          <DarkModeSwitcher/>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import CountryFlag from '@scripts/components/CountryFlag'
import DarkModeSwitcher from '@scripts/components/DarkModeSwitcher'
import SignInForm from '@scripts/components/form/SignInForm'
import FontAwesomeIcon from '@scripts/fontawesome'
import Security from '@scripts/services/security'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'Navbar',
  components: {
    CountryFlag,
    DarkModeSwitcher,
    FontAwesomeIcon,
    SignInForm
  },
  computed: {
    ...mapGetters([
      'darkMode',
      'locale',
      'user'
    ]),
    navbarClass () {
      return this.darkMode ? ['bg-dark', 'navbar-dark'] : ['bg-white', 'navbar-light']
    }
  },
  methods: {
    ...mapActions(['setLocale']),
    logout () {
      Security.logout()
    }
  }
}
</script>
