import axios from "axios";

export default {
    getList() {
        return axios.get('issue/list')
            .then(response => {
                return response.data;
            })
            .catch(error => {
                console.log(error);
                return [];
            })
    }
}