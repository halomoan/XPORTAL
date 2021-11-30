//import axios from 'axios'

const ROLE_API_URI = '/api/manage/role'

const state = {
    role: { id: 0, name: null },
    permissions: null
}
const getters = {
    role: (state) => state.role,
    permissions: (state) => state.permissions
}
const actions = {
    async getRolePermissions({ commit }, payload) {
        const response = await axios.get(
            `/api/manage/role/${payload.id}/permissions`
        )
        //console.log(response.data)
        const role = response.data.role
        const permissions = response.data.permissions
        commit('SET_ROLE', role)
        commit('SET_PERMISSIONS', permissions)
    }
}

const mutations = {
    SET_ROLE: (state, role) => (state.role = role),
    SET_PERMISSIONS: (state, permissions) => (state.permissions = permissions)
}

export default {
    state,
    getters,
    actions,
    mutations
}
