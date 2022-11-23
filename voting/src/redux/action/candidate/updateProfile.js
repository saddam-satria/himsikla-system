import { doc, updateDoc } from 'firebase/firestore';
import { firestore } from '../../../config/firebase';
import { CANDIDATE_ERROR } from '../../types';

const updateProfile = (id, profile) => async (dispatch) => {
  const candidateRef = doc(firestore, 'candidate', id);
  try {
    updateDoc(candidateRef, { profile });
  } catch (error) {
    dispatch({
      type: CANDIDATE_ERROR,
      message: error.message,
    });
  }
};

export default updateProfile;
