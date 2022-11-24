import { addDoc } from 'firebase/firestore';
import voterCollection from '../../../firebase/collections/voter';
import { VOTER_ERROR } from '../../types';

const postVoter = (payload) => async (dispatch) => {
  
  try {
    await addDoc(voterCollection, payload);
  } catch (error) {
    
    dispatch({
      type: VOTER_ERROR,
      message: error.message,
    });
  }
};

export default postVoter;
