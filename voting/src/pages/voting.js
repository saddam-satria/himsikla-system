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

  const [errorVoting, setErrorVoting] = React.useState({
    error: false,
    message: ''
  })
  const [currentVoter,setCurrentVoter] = React.useState(null);


  React.useEffect(() => {
    if(voterState.voter){
      setCurrentVoter(voterState.voter)
    }
  },[voterState])


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





  const voteHandler = (e,candidate) => {
    e.preventDefault();
    const date = new Date(Date.now());
    const currentUser = userState.data;
    dispatch(getVoter(currentUser.member.name))


    
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

    if(currentVoter.name === currentUser.member.name){
      setErrorVoting({
        error :true,
        message: "Hanya Boleh Sekali"
      })
      return;
    }
    

    dispatch(postVoter(payload));
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
      {candidateState.loading || voterState.loading && (
        <div className="fixed left-0 top-0 z-10 h-screen w-screen">
          <div className="flex flex-col space-y-2 justify-center h-full w-full items-center">
            <img
              src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRL2tq0IANwwvpD-dJ-YD8Zbe0Xeriw2h-mdw&usqp=CAU"
              alt="circle loading"
              className="w-36 h-36 object-contain"
            />
            <span className="text-sm capitalize">tunggu sebentar</span>
          </div>
        </div>
      )}
      {
        userState.data && currentVoter && userState.data.member.name !== currentVoter.name &&
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
      }
    </div>
  );
}

export default Voting;
