import { createStore } from 'vuex'

const store = createStore({
  state() {
    return {
      user: null,
      products: [],
    }
  },
  getters: {
    user: (state) => {
      return state.user
    },
    products: (state) => {
      return state.products
    },
  },
  actions: {
    user(context, user) {
      context.commit('user', user)
    },
    products(context, products) {
      context.commit('products', products)
    },
  },
  mutations: {
    user(state, user) {
      state.user = user
    },
    products(state, products) {
      state.products = products
    },
  }
})

export default store