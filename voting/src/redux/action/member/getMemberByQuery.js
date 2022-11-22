import axios from '../../../config/axios';
import { headers } from '../../../helpers/headers';
import { GET_MEMBERS, MEMBER_ERROR, MEMBER_LOADING } from '../../types';

const getMemberByQuery = (token, query) => (dispatch) => {
  dispatch({
    type: MEMBER_LOADING,
  });
  axios
    .get(`users?query=${query}`, {
      headers: headers(token),
    })
    .then((response) => {
      const { data } = response;

      dispatch({
        type: GET_MEMBERS,
        data: data.data,
        totalData: data.totalQuery,
      });
    })
    .catch((error) => {
      dispatch({
        type: MEMBER_ERROR,
        message: error.response.data.error.message,
      });
    });
};

export default getMemberByQuery;
