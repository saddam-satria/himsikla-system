import { onSnapshot, orderBy, query } from "firebase/firestore";
import VoterCollection from "../../../firebase/collections/voter";
import { GET_VOTERS, VOTER_ERROR, VOTER_LOADING } from "../../types";



const getVoters = () => (dispatch) => {
    dispatch({
        type: VOTER_LOADING,
      });
      try {
        const voterRef = query(
        VoterCollection,
          orderBy('createdAt', 'desc')
        );
    
        onSnapshot(voterRef, {
          next(snap) {
            const data = [];
    
            snap.docs.map((doc) => {
              data.push({ ...doc.data(), id: doc.id });
            });
    
            dispatch({
              type: GET_VOTERS,
              data,
            });
          },
          error(error) {
            dispatch({
              type: VOTER_ERROR,
              message: error.message,
            });
          },
        });
      } catch (error) {
        dispatch({
          type: VOTER_ERROR,
          message: error.message,
        });
      }
}

export default getVoters