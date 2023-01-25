import {  deleteDoc, doc } from 'firebase/firestore';
import { firestore } from '../../../config/firebase';
import {  VOTER_ERROR } from '../../types';

const deleteVoter = (id) => async (dispatch) => {
  const voterRef = doc(firestore, 'voter', id);
  try {
    await deleteDoc(voterRef);
  } catch (error) {
    dispatch({
      type: VOTER_ERROR,
      message: error.message,
    });
  }
};

export default deleteVoter;
