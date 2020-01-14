import axios from '../config/axios';

const CategoriesApi = {
    get: (params = {}) => {
        return axios.get(`/v1/categories`, {params});
    }
}

export default CategoriesApi;