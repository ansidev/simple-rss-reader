import {get} from './api'

export function getCategories() {
    return get(`/api/categories`)
        .then((response) => {
            return response.data.categories;
        })
        .catch(() => {
            console.log('handle server error from here');
        });
}
