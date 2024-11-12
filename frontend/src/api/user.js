import axios from "axios";

export default {
    getMasters(token) {
        return axios.get('user/masters', {
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
    getStatuses(token) {
        return axios.get('user/statuses', {
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
    setStatus(token, statusId, userId = null) {
        return axios.post('user/set-status', {
            id: userId,
            statusId,
        }, {
            headers: {
                'Authorization': `Token ${token}`,
            },
        })
            .then(response => {
                alert('Статус изменен');
                return true;
            })
            .catch(error => {
                console.log(error);
                alert('Ошибка при сохранении, см. консоль');
                return false;
            })
    },
    getStatus(token) {
        return axios.get('user/status', {
            headers: {
                'Authorization': `Token ${token}`,
            }
        })
            .then(response => {
                return response.data;
            })
            .catch(error => {
                console.log(error);
            });
    }
}