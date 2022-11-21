import axios from '../../../config/axios';
import { headers } from '../../../helpers/headers';
import { GET_USER, USER_ERROR, USER_LOADING } from '../../types';

const getUser = (token) => (dispatch) => {
  dispatch({
    type: USER_LOADING,
  });
  axios
    .post(
      'me',
      {},
      {
        headers: headers(token),
      }
    )
    .then((response) => {
      const { data } = response;

      dispatch({
        type: GET_USER,
        data: data.data,
      });
    })
    .catch((error) => {
      dispatch({
        type: USER_ERROR,
        message: error.response.data.error.message,
      });
    });
};

export default getUser;
