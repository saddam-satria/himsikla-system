import { onSnapshot,  query, where } from "firebase/firestore";
import VoterCollection from "../../../firebase/collections/voter";
import { GET_VOTER, VOTER_ERROR, VOTER_LOADING } from "../../types";



const getVoter = (name) => (dispatch) => {
    dispatch({
        type: VOTER_LOADING,
      });
      try {
        const voterRef = query(
        VoterCollection,
          where("name", "==", name)
        );
    
        onSnapshot(voterRef, {
          next(snap) {
          try {
            const data = [];
    
            snap.docs.map((doc) => {
              data.push({ ...doc.data(), id: doc.id });
            });


            if(data.length < 1) throw new Error('voter not found')
    
            dispatch({
              type: GET_VOTER,
              data: data[0],
            });
          } catch (error) {
            dispatch({
              type: VOTER_ERROR,
              message: error.message
            })
          }
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

export default getVoter