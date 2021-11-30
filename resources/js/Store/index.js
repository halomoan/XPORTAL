import Vue from 'vue'
import Vuex from 'vuex'

import role from './modules/role'

Vue.use(Vuex)

// Create store
export default new Vuex.Store({
    modules: {
        role
    }
})
