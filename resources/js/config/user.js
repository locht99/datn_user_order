import instance from './config'

export function login(data) {
    return instance.post('login', data)
}
export function signinWithGoogle() {
    return instance.post('google-signin')
}

export function register(data) {
    return instance.post('register', data);
}

export function getUser() {
    const token = localStorage.getItem('token') || null;
    return instance.get('user', {
        headers: {
            Authorization: `Bearer ${token}`
        }
    })
}