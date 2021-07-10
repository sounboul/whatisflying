import i18n from '@scripts/i18n'

const state = {
  baseLayer: 'roadmap',
  darkMode: false,
  displayMode: 'grid',
  locale: null,
  showAircrafts: true,
  showAircraftsLegend: false,
  showAirports: true,
  showAirportsLegend: false,
  showAtmosphericPressure: false,
  showCloudCoverage: false,
  showFilters: false,
  showFixes: false,
  showGraticule: false,
  showNavaids: true,
  showNavaidsLegend: false,
  showPrecipitations: false,
  showSort: false,
  showTemperature: false,
  showWindSpeed: false
}

const getters = {
  baseLayer: store => store.baseLayer,
  darkMode: store => store.darkMode,
  displayMode: store => store.displayMode,
  locale: store => store.locale,
  showAircrafts: store => store.showAircrafts,
  showAircraftsLegend: store => store.showAircraftsLegend,
  showAirports: store => store.showAirports,
  showAirportsLegend: store => store.showAirportsLegend,
  showAtmosphericPressure: store => store.showAtmosphericPressure,
  showCloudCoverage: store => store.showCloudCoverage,
  showFilters: store => store.showFilters,
  showFixes: store => store.showFixes,
  showGraticule: store => store.showGraticule,
  showNavaids: store => store.showNavaids,
  showNavaidsLegend: store => store.showNavaidsLegend,
  showPrecipitations: store => store.showPrecipitations,
  showSort: store => store.showSort,
  showTemperature: store => store.showTemperature,
  showWindSpeed: store => store.showWindSpeed
}

const mutations = {
  setBaseLayer (state, baseLayer) {
    state.baseLayer = baseLayer
  },
  setDarkMode (state, darkMode) {
    state.darkMode = darkMode
  },
  setDisplayMode (state, displayMode) {
    state.displayMode = displayMode
  },
  setLocale (state, locale) {
    state.locale = locale
    i18n.global.locale = locale
  },
  setShowAircrafts (state, showAircrafts) {
    state.showAircrafts = showAircrafts
  },
  setShowAircraftsLegend (state, showAircraftsLegend) {
    state.showAircraftsLegend = showAircraftsLegend
  },
  setShowAirports (state, showAirports) {
    state.showAirports = showAirports
  },
  setShowAirportsLegend (state, showAirportsLegend) {
    state.showAirportsLegend = showAirportsLegend
  },
  setShowAtmosphericPressure (state, showAtmosphericPressure) {
    state.showAtmosphericPressure = showAtmosphericPressure
  },
  setShowCloudCoverage (state, showCloudCoverage) {
    state.showCloudCoverage = showCloudCoverage
  },
  setShowFilters (state, showFilters) {
    state.showFilters = showFilters
  },
  setShowFixes (state, showFixes) {
    state.showFixes = showFixes
  },
  setShowGraticule (state, showGraticule) {
    state.showGraticule = showGraticule
  },
  setShowNavaids (state, showNavaids) {
    state.showNavaids = showNavaids
  },
  setShowNavaidsLegend (state, showNavaidsLegend) {
    state.showNavaidsLegend = showNavaidsLegend
  },
  setShowPrecipitations (state, showPrecipitations) {
    state.showPrecipitations = showPrecipitations
  },
  setShowSort (state, showSort) {
    state.showSort = showSort
  },
  setShowTemperature (state, showTemperature) {
    state.showTemperature = showTemperature
  },
  setShowWindSpeed (state, showWindSpeed) {
    state.showWindSpeed = showWindSpeed
  }
}

const actions = {
  setBaseLayer (context, baseLayer) {
    context.commit('setBaseLayer', baseLayer)
  },
  setDarkMode (context, darkMode) {
    context.commit('setDarkMode', darkMode)
  },
  setDisplayMode (context, displayMode) {
    context.commit('setDisplayMode', displayMode)
  },
  setLocale (context, locale) {
    context.commit('setLocale', locale)
  },
  setShowAircrafts (context, showAircrafts) {
    context.commit('setShowAircrafts', showAircrafts)
  },
  setShowAircraftsLegend (context, showAircraftsLegend) {
    context.commit('setShowAircraftsLegend', showAircraftsLegend)
  },
  setShowAirports (context, showAirports) {
    context.commit('setShowAirports', showAirports)
  },
  setShowAirportsLegend (context, showAirportsLegend) {
    context.commit('setShowAirportsLegend', showAirportsLegend)
  },
  setShowAtmosphericPressure (context, showAtmosphericPressure) {
    context.commit('setShowAtmosphericPressure', showAtmosphericPressure)
  },
  setShowCloudCoverage (context, showCloudCoverage) {
    context.commit('setShowCloudCoverage', showCloudCoverage)
  },
  setShowFilters (context, showFilters) {
    context.commit('setShowFilters', showFilters)
  },
  setShowFixes (context, showFixes) {
    context.commit('setShowFixes', showFixes)
  },
  setShowGraticule (context, showGraticule) {
    context.commit('setShowGraticule', showGraticule)
  },
  setShowNavaids (context, showNavaids) {
    context.commit('setShowNavaids', showNavaids)
  },
  setShowNavaidsLegend (context, showNavaidsLegend) {
    context.commit('setShowNavaidsLegend', showNavaidsLegend)
  },
  setShowPrecipitations (context, showPrecipitations) {
    context.commit('setShowPrecipitations', showPrecipitations)
  },
  setShowSort (context, showSort) {
    context.commit('setShowSort', showSort)
  },
  setShowTemperature (context, showTemperature) {
    context.commit('setShowTemperature', showTemperature)
  },
  setShowWindSpeed (context, showWindSpeed) {
    context.commit('setShowWindSpeed', showWindSpeed)
  }
}

const settings = {
  state,
  getters,
  mutations,
  actions
}

export default settings
