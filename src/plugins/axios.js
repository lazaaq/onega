import ax from 'axios'



export const axios = ax

export default {
    testing (Vue) {
        Vue.prototype.$axios = ax
    }
}