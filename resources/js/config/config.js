import axios from "axios";
const URL = '/api/';

const config = axios.create({
    baseURL: URL,
    headers: {
        'Content-Type': 'application/json',
    }
})
export default config;