import axios from '../../../config/axios';
import { headers } from '../../../helpers/headers';
import { GET_MEMBERS, MEMBER_ERROR, MEMBER_LOADING } from '../../types';

const getMembers = (token, page, take) => (dispatch) => {
  dispatch({
    type: MEMBER_LOADING,
  });
  axios
    .get(`users?page=${page}&take=${take ?? 10}`, {
      headers: headers(token),
    })
    .then((response) => {
      const { data } = response;

      dispatch({
        type: GET_MEMBERS,
        data: data.data,
      });
    })
    .catch((error) => {
      dispatch({
        type: MEMBER_ERROR,
        message: error.response.data.error.message,
      });
    });
};

export default getMembers;
