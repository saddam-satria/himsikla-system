import React from "react"; 
import { useDispatch, useSelector } from "react-redux";
import getVoter from "../redux/action/voter/getVoter";


const VoterHook = () => {
  const userState = useSelector((state) => state.user);
  const dispatch = useDispatch();

  React.useEffect(() => {
      
    if (userState.data && userState.data.member) {
        dispatch(getVoter(userState.data.member.name))
      }
    
    
  }, [dispatch, userState]);
}

export default VoterHook;