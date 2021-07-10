import qs from 'qs'
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'live_tracker',
    component: () => import(/* webpackChunkName: "live-tracker" */ '@scripts/views/LiveTracker')
  },
  {
    path: '/activate-account/:id/:token',
    name: 'activate_account',
    component: () => import(/* webpackChunkName: "security" */ '@scripts/views/ActivateAccount'),
    props: true
  },
  {
    path: '/admin/users',
    name: 'admin_users',
    component: () => import(/* webpackChunkName: "admin" */ '@scripts/views/admin/Users')
  },
  {
    path: '/contact',
    name: 'contact',
    component: () => import(/* webpackChunkName: "contact" */ '@scripts/views/Contact')
  },
  {
    path: '/cookie-policy',
    name: 'cookie_policy',
    component: () => import(/* webpackChunkName: "static" */ '@scripts/views/static/CookiePolicy')
  },
  {
    path: '/database/aircraft',
    name: 'database_aircrafts',
    component: () => import(/* webpackChunkName: "database" */ '@scripts/views/database/Aircrafts')
  },
  {
    path: '/database/aircraft/:icao24bitAddress',
    name: 'database_aircraft',
    component: () => import(/* webpackChunkName: "database" */ '@scripts/views/database/Aircraft'),
    props: true
  },
  {
    path: '/database/aircraft-types',
    name: 'database_aircraft_types',
    component: () => import(/* webpackChunkName: "database" */ '@scripts/views/database/AircraftTypes')
  },
  {
    path: '/database/aircraft-type/:icaoCode',
    name: 'database_aircraft_type',
    component: () => import(/* webpackChunkName: "database" */ '@scripts/views/database/AircraftType'),
    props: true
  },
  {
    path: '/database/airlines',
    name: 'database_airlines',
    component: () => import(/* webpackChunkName: "database" */ '@scripts/views/database/Airlines')
  },
  {
    path: '/database/airline/:icaoCode',
    name: 'database_airline',
    component: () => import(/* webpackChunkName: "database" */ '@scripts/views/database/Airline'),
    props: true
  },
  {
    path: '/database/airports',
    name: 'database_airports',
    component: () => import(/* webpackChunkName: "database" */ '@scripts/views/database/Airports')
  },
  {
    path: '/database/airport/:icaoCode',
    name: 'database_airport',
    component: () => import(/* webpackChunkName: "database" */ '@scripts/views/database/Airport'),
    props: true
  },
  {
    path: '/database/flights',
    name: 'database_flights',
    component: () => import(/* webpackChunkName: "database" */ '@scripts/views/database/Flights')
  },
  {
    path: '/database/flight/:flightNumber',
    name: 'database_flight',
    component: () => import(/* webpackChunkName: "database" */ '@scripts/views/database/Flight'),
    props: true
  },
  {
    path: '/database/navaids',
    name: 'database_navaids',
    component: () => import(/* webpackChunkName: "database" */ '@scripts/views/database/Navaids')
  },
  {
    path: '/database/navaid/:slug',
    name: 'database_navaid',
    component: () => import(/* webpackChunkName: "database" */ '@scripts/views/database/Navaid'),
    props: true
  },
  {
    path: '/legal-notice',
    name: 'legal_notice',
    component: () => import(/* webpackChunkName: "static" */ '@scripts/views/static/LegalNotice')
  },
  {
    path: '/privacy-policy',
    name: 'privacy_policy',
    component: () => import(/* webpackChunkName: "static" */ '@scripts/views/static/PrivacyPolicy')
  },
  {
    path: '/sign-in',
    name: 'sign_in',
    component: () => import(/* webpackChunkName: "sign-in" */ '@scripts/views/SignIn')
  },
  {
    path: '/sign-up',
    name: 'sign_up',
    component: () => import(/* webpackChunkName: "sign-up" */ '@scripts/views/SignUp')
  },
  {
    path: '/request-password-reset',
    name: 'request_password_reset',
    component: () => import(/* webpackChunkName: "security" */ '@scripts/views/RequestPasswordReset')
  },
  {
    path: '/reset-password/:id/:token',
    name: 'reset_password',
    component: () => import(/* webpackChunkName: "security" */ '@scripts/views/ResetPassword'),
    props: true
  },
  {
    path: '/user/preferences',
    name: 'user_preferences',
    component: () => import(/* webpackChunkName: "user" */ '@scripts/views/user/Preferences')
  },
  {
    path: '/user/privacy',
    name: 'user_privacy',
    component: () => import(/* webpackChunkName: "user" */ '@scripts/views/user/Privacy')
  },
  {
    path: '/user/security',
    name: 'user_security',
    component: () => import(/* webpackChunkName: "user" */ '@scripts/views/user/Security')
  },
  {
    path: '/not-found',
    name: 'not_found',
    component: () => import(/* webpackChunkName: "error" */ '@scripts/views/error/NotFound')
  },
  {
    path: '/:catchAll(.*)',
    component: () => import(/* webpackChunkName: "error" */ '@scripts/views/error/NotFound')
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  parseQuery: string => qs.parse(string, {
    arrayFormat: 'brackets'
  }),
  scrollBehavior: (to, from, savedPosition) => {
    if (to.hash) {
      return {
        el: to.hash,
        behavior: 'smooth'
      }
    }

    return savedPosition || {
      behavior: 'smooth',
      top: 0
    }
  },
  stringifyQuery: params => qs.stringify(params, {
    arrayFormat: 'brackets',
    encode: false,
    filter: (prefix, value) => value !== '' ? value : undefined,
    indices: false,
    skipNulls: true
  })
})

export default router
