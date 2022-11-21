import { USER_ERROR, USER_SET_TOKEN } from '../../types';

const getToken = () => (dispatch) => {
  let tokenStorage;

  try {
    tokenStorage = JSON.parse(localStorage.getItem('token'));
  } catch (error) {
    dispatch({
      type: USER_ERROR,
      message: 'Somethings Wrong With Local Storage',
    });
    return;
  }

  if (tokenStorage) {
    const { token } = tokenStorage;
    dispatch({
      type: USER_SET_TOKEN,
      data: token,
    });
  }
};
export default getToken;
