import axios from '../config/axios'

const cartApi = {
    addToCart: (data) => {
        return axios.post(`/api/cart?_token=${localStorage.getItem('token')}`, data);
    },

    getCart: () => {
        return axios.post(`/api/cart/get?_token=${localStorage.getItem('token')}`)
    }
}

export default cartApi;