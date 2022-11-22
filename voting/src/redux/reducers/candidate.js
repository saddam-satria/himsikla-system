import {
  CANDIDATE_ERROR,
  CANDIDATE_LOADING,
  GET_CANDIDATES,
  POST_CANDIDATE,
} from '../types';

const initalState = {
  data: null,
  error: false,
  message: null,
  loading: false,
};

const candidate = (state = initalState, action) => {
  switch (action.type) {
    case GET_CANDIDATES:
      return {
        ...state,
        data: action.data,
        loading: false,
        error: false,
        message: null,
      };
    case POST_CANDIDATE:
      return {
        ...state,
        data: { ...state.data, ...action.data },
        loading: false,
        error: false,
        message: null,
      };

    case CANDIDATE_ERROR:
      return {
        ...state,
        data: null,
        loading: false,
        error: true,
        message: action.message,
      };
    case CANDIDATE_LOADING:
      return {
        ...state,
        loading: true,
      };

    default:
      return state;
  }
};

export default candidate;
