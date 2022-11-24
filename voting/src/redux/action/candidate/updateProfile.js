import { doc, updateDoc } from 'firebase/firestore';
import { firestore } from '../../../config/firebase';
import { CANDIDATE_ERROR } from '../../types';

const updateProfile = (id, profile) => async (dispatch) => {
  const date = new Date(Date.now());

  const candidateRef = doc(firestore, 'candidate', id);
  try {
    await updateDoc(candidateRef, { profile , updatedAt: `${date.getDate()}-${
      date.getMonth() + 1
    }-${date.getFullYear()} ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`, });
  } catch (error) {
    dispatch({
      type: CANDIDATE_ERROR,
      message: error.message,
    });
  }
};

export default updateProfile;
