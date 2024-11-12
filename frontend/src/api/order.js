import axios from "axios";

export default {
    getStatuses(token) {
        return axios.get('order/statuses', {
            headers: {
                'Authorization': `Token ${token}`,
            }
        })
            .then(response => {
                return response.data;
            })
            .catch(error => {
                console.log(error);
                alert('Ошибка, см. консоль');
                return [];
            })
    },
    getOrders(token, filter) {
        return axios.get('order/list', {
            headers: {
                'Authorization': `Token ${token}`,
            },
            params: filter,
        })
            .then(response => {
                return response.data;
            })
            .catch(error => {
                console.log(error);
                alert('Ошибка загрузки заказов, см. консоль');
                return [];
            })
    },
    create(order) {
        return axios.post('order/create', order)
            .then(response => {
                return true;
            })
            .catch(error => {
                console.log(error);
                return false;
            })
    },
    getForCurrentUser(token) {
        return axios.get('order/current-user', {
            headers: {
                'Authorization': `Token ${token}`,
            },
        }).then(response => {
            return response.data;
        }).catch(error => {
            console.log(error);
            alert('Ошибка загрузки заказов, см. консоль');
            return [];
        })
    },
    getHistoryForCurrentUser(token) {
        return axios.get('order/current-user-history', {
            headers: {
                'Authorization': `Token ${token}`,
            },
        }).then(response => {
            return response.data;
        }).catch(error => {
            console.log(error);
            alert('Ошибка загрузки заказов, см. консоль');
            return [];
        })
    },
    update(token, data) {
        return axios.post('order/update', data, {
            headers: {
                'Authorization': `Token ${token}`,
            },
        })
            .then(response => {
                return true;
            })
            .catch(error => {
                console.log(error);
                alert('Ошибка при сохранении, см. консоль');
                return false;
            })
    },
    addComment(token, orderId, text) {
        return axios.post('order/add-comment', {
            orderId,
            text,
        }, {
            headers: {
                'Authorization': `Token ${token}`,
            },
        })
            .then(response => {
                return true;
            })
            .catch(error => {
                console.log(error);
                alert('Ошибка при сохранении, см. консоль');
                return false;
            })
    }
}