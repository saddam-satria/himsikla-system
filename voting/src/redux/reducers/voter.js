import { GET_VOTER, GET_VOTERS, VOTER_ERROR, VOTER_LOADING } from '../types';

const initalState = {
  data: null,
  error: false,
  message: null,
  loading: false,
  voter: null
};

const voter = (state = initalState, action) => {
  switch (action.type) {
    case GET_VOTERS:
      return {
        ...state,
        data: action.data,
        loading: false,
        error: false,
        message: null,
        totalData: action.totalData,
      };

    case GET_VOTER:
      return {
        ...state,
        voter: action.data,
        loading: false,
        error: false,
        message: null,
        totalData: action.totalData,
      };

    case VOTER_ERROR:
      return {
        ...state,
        data: null,
        loading: false,
        error: true,
        message: action.message,
      };
    case VOTER_LOADING:
      return {
        ...state,
        loading: true,
      };

    default:
      return state;
  }
};

export default voter;
