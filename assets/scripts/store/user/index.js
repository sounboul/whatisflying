const state = {
  token: null,
  user: null
}

const getters = {
  token: store => store.token,
  user: store => store.user
}

const mutations = {
  setToken (state, token) {
    state.token = token
  },
  setUser (state, user) {
    state.user = user
  }
}

const actions = {
  setToken (context, token) {
    context.commit('setToken', token)
  },
  setUser (context, user) {
    context.commit('setUser', user)
  }
}

const user = {
  state,
  getters,
  mutations,
  actions
}

export default user
