import axios from "axios";
const URL = "/api/";
const token = localStorage.getItem("token") || null;

const config = axios.create({
    baseURL: URL,
    headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
    },
});
export default config;
