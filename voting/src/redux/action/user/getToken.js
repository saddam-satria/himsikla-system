import { USER_ERROR, USER_SET_TOKEN } from '../../types';

const getToken = () => (dispatch) => {
  const tokenStorage = JSON.parse(localStorage.getItem('token'));

  if (!tokenStorage) {
    dispatch({
      type: USER_ERROR,
      message: 'Invalid Token',
    });

    return;
  }

  const { token } = tokenStorage;
  dispatch({
    type: USER_SET_TOKEN,
    data: token,
  });
};
export default getToken;
