import axios from '../../../config/axios';
import { USER_ERROR, USER_LOADING, USER_LOGIN } from '../../types';

const loginReduxAction = (email, token) => (dispatch) => {
  const payload = {
    email,
    token,
  };

  dispatch({
    type: USER_LOADING,
    loading: true,
  });
  axios
    .post('login', payload)
    .then((response) => {
      const { data } = response;

      if (data.status.includes('error')) throw new Error(data.message);

      localStorage.setItem('token', JSON.stringify({ token: data.data }));

      dispatch({
        type: USER_LOGIN,
        data: data.data,
      });
    })
    .catch((error) => {
      let data;
      let message;

      message = error.message;
      if (error.response) {
        data = error.response.data;
        message = data.error.message;
      }

      dispatch({
        type: USER_ERROR,
        message,
      });
    });
};

export default loginReduxAction;
