import {
  GET_USER,
  USER_ERROR,
  USER_LOADING,
  USER_LOGIN,
  USER_SET_TOKEN,
} from '../types';

const initalState = {
  data: null,
  error: false,
  message: null,
  loading: false,
  token: null,
};

const user = (state = initalState, action) => {
  switch (action.type) {
    case GET_USER:
      return {
        ...state,
        data: action.data,
        loading: false,
        error: false,
        message: null,
      };
    case USER_LOGIN:
      return {
        ...state,
        data: action.data,
        loading: false,
        error: false,
        message: null,
      };
    case USER_SET_TOKEN:
      return {
        ...state,
        token: action.data,
        loading: false,
        error: false,
        message: null,
      };
    case USER_ERROR:
      return {
        ...state,
        data: null,
        loading: false,
        error: true,
        message: action.message,
      };
    case USER_LOADING:
      return {
        ...state,
        loading: true,
      };

    default:
      return state;
  }
};

export default user;
