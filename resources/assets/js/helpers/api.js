import axios from 'axios'

export function get(url, params = {}) {
    return axios.get(url, {
        headers: {
            'Authorization': `Bearer ${window.apiToken}`
        },
        params: params
    })
}

export function post(url, payload) {
    return axios({
        method: 'POST',
        url: url,
        data: payload,
        headers: {
            'Authorization': `Bearer ${window.apiToken}`
        }
    })
}

export function put(url, payload) {
    return axios({
        method: 'PUT',
        url: url,
        data: payload,
        headers: {
            'Authorization': `Bearer ${window.apiToken}`
        }
    })
}

// delete is reserved keyword
export function del(url) {
    return axios({
        method: 'DELETE',
        url: url,
        headers: {
            'Authorization': `Bearer ${window.apiToken}`
        }
    })
}

export function interceptors(cb) {
    axios.interceptors.response.use((res) => {
        return res;
    }, (err) => {
        cb(err);
        return Promise.reject(err)
    })
}
