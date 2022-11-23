import {  deleteDoc, doc } from 'firebase/firestore';
import { firestore } from '../../../config/firebase';
import { CANDIDATE_ERROR } from '../../types';

const deleteCandidate = (id) => async (dispatch) => {
  const candidateRef = doc(firestore, 'candidate', id);
  try {
    deleteDoc(candidateRef);
  } catch (error) {
    dispatch({
      type: CANDIDATE_ERROR,
      message: error.message,
    });
  }
};

export default deleteCandidate;
