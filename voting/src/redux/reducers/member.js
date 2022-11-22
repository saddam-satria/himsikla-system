import { GET_MEMBERS, MEMBER_ERROR, MEMBER_LOADING } from '../types';

const initalState = {
  data: null,
  error: false,
  message: null,
  loading: false,
};

const member = (state = initalState, action) => {
  switch (action.type) {
    case GET_MEMBERS:
      return {
        ...state,
        data: action.data,
        loading: false,
        error: false,
        message: null,
        totalData: action.totalData,
      };

    case MEMBER_ERROR:
      return {
        ...state,
        data: null,
        loading: false,
        error: true,
        message: action.message,
      };
    case MEMBER_LOADING:
      return {
        ...state,
        loading: true,
      };

    default:
      return state;
  }
};

export default member;
