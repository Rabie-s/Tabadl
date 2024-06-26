import axios from 'axios';


export const getTotalBooks = async () => {

    const response = await axios.get(`v1/admin/statistics/totalBooks`)
    return response

}

