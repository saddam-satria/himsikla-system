import React from 'react';
import { useDispatch, useSelector } from 'react-redux';
import CardComponent from '../components/CardComponent';
import ClockComponent from '../components/ClockComponent';
import getCandidates from '../redux/action/candidate/getCandidates';
import getVoter from '../redux/action/voter/getVoter';
import postVoter from '../redux/action/voter/postVoter';


function Voting() {
  const candidateState = useSelector((state) => state.candidate);
  const userState = useSelector((state) => state.user);
  const voterState = useSelector((state) => state.voter);


  const render = React.useRef(true);

  const dispatch = useDispatch();

  React.useEffect(() => {
    if (render.current) {
      if (!candidateState.data) {
        dispatch(getCandidates());
      }
    }
    return () => {
      render.current = false;
    };
  }, [dispatch, candidateState]);


  React.useEffect(() => {
    if (render.current) {
      if(userState.data && userState.data.member){
        dispatch(getVoter(userState.data.member.name));
      }
      
    }
    return () => {
      render.current = false;
    };
  }, [dispatch, userState]);

  const voteHandler = (e,candidate) => {
    e.preventDefault();
    const date = new Date(Date.now());
    const currentUser = userState.data;

    
    const payload = {
      candidate, 
      token: currentUser.member.token,
      name: currentUser.member.name,
      email: currentUser.email,
      occupation : currentUser.member.occupation,
      periode: currentUser.member.periode,
      createdAt: `${date.getDate()}-${
        date.getMonth() + 1
      }-${date.getFullYear()} ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`,
      updatedAt: null,
    }
    

    // dispatch(postVoter(payload));
    console.log(voterState);
  }






  return (
    <div>
      <div className="my-2">
        <ClockComponent />
        <div className="py-2">
          <span className="text-lg font-bold text-blue-800">
            Total Suara Masuk : 0
          </span>
        </div>
      </div>
      <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-8">
        {candidateState.data &&
          candidateState.data.map((candidate, index) => {
            return (
              <CardComponent
                buttonText={'Vote'}
                name={candidate.name}
                occupation={candidate.occupation}
                periode={candidate.periode}
                image={candidate.image}
                key={index}
                buttonClick={(e) => voteHandler(e, candidate.name)}
              />
            );
          })}
      </div>
    </div>
  );
}

export default Voting;
