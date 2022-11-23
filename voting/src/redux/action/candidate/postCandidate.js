import { addDoc } from 'firebase/firestore';
import candidateCollection from '../../../firebase/collections/candidates';
import { CANDIDATE_ERROR } from '../../types';

const postCandidate = (payload) => async (dispatch) => {
  try {
    addDoc(candidateCollection, payload);
  } catch (error) {
    dispatch({
      type: CANDIDATE_ERROR,
      message: error.message,
    });
  }
};

export default postCandidate;
