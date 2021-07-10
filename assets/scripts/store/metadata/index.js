const state = {
  metaDescription: null,
  metaImages: null,
  metaRobots: null,
  metaTitle: null,
  metaUrl: null,
  pageTitle: null
}

const getters = {
  metaDescription: store => store.metaDescription,
  metaImages: store => store.metaImages,
  metaRobots: store => store.metaRobots,
  metaTitle: store => store.metaTitle,
  metaUrl: store => store.metaUrl,
  pageTitle: store => store.pageTitle
}

const mutations = {
  setMetaDescription (state, metaDescription) {
    state.metaDescription = metaDescription
  },
  setMetaImages (state, metaImages) {
    state.metaImages = metaImages
  },
  setMetaRobots (state, metaRobots) {
    state.metaRobots = metaRobots
  },
  setMetaTitle (state, metaTitle) {
    state.metaTitle = metaTitle
  },
  setMetaUrl (state, metaUrl) {
    state.metaUrl = metaUrl
  },
  setPageTitle (state, pageTitle) {
    state.pageTitle = pageTitle
  }
}

const actions = {
  setMetaDescription (context, metaDescription) {
    context.commit('setMetaDescription', metaDescription)
  },
  setMetaImages (context, metaImages) {
    context.commit('setMetaImages', metaImages)
  },
  setMetaRobots (context, metaRobots) {
    context.commit('setMetaRobots', metaRobots)
  },
  setMetaTitle (context, metaTitle) {
    context.commit('setMetaTitle', metaTitle)
  },
  setMetaUrl (context, metaUrl) {
    context.commit('setMetaUrl', metaUrl)
  },
  setPageTitle (context, pageTitle) {
    context.commit('setPageTitle', pageTitle)
  }
}

const metadata = {
  state,
  getters,
  mutations,
  actions
}

export default metadata
