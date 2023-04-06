import axiosClient from "../axios";

export function login({commit}, data) {
    return axiosClient.post('/login', data)
        .then(({data}) => {
            commit('setUser', data.user);
            commit('setToken', data.token);
            return data
        });
}

export function logout({commit}, data) {
    return axiosClient.post('/logout', data)
        .then((response) => {
            commit('setToken', null);
            return response;
        });
}
