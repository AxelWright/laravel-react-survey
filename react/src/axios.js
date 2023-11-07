import axios from 'axios';

const aciosClient = axios.create({
    baseURL: `${import.meta.env.VITE_API_BASE_URL}/api`
})

axiosClient.interceptors.request.use((config) => {
    const token = '123'; //TODO
    config.headers.Authorization = `Bearer `
})

axiosClient.interceptors.response.use(response => {
    return response;
},error => {
    if (error.response && error.response.status === 401) {
        ReadableStreamDefaultController.navigate('/login')
    return error;
    }
    throw error;
})

export default axiosClient;
