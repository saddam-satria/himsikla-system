import { onSnapshot, orderBy, query } from 'firebase/firestore';
import candidateCollection from '../../../firebase/collections/candidates';
import {
  CANDIDATE_ERROR,
  CANDIDATE_LOADING,
  GET_CANDIDATES,
} from '../../types';

const getCandidates = () => (dispatch) => {
  dispatch({
    type: CANDIDATE_LOADING,
  });
  try {
    const candidatesRef = query(
      candidateCollection,
      orderBy('createdAt', 'desc')
    );

    onSnapshot(candidatesRef, {
      next(snap) {
        const data = [];

        snap.docs.map((doc) => {
          data.push({ ...doc.data(), id: doc.id });
        });

        dispatch({
          type: GET_CANDIDATES,
          data,
        });
      },
      error(error) {
        dispatch({
          type: CANDIDATE_ERROR,
          message: error.message,
        });
      },
    });
  } catch (error) {
    dispatch({
      type: CANDIDATE_ERROR,
      message: error.message,
    });
  }
};

export default getCandidates;
