import React from 'react';
import { useDispatch, useSelector } from 'react-redux';
import CardComponent from '../components/CardComponent';
import ClockComponent from '../components/ClockComponent';
import LoadingComponent from '../components/LoadingComponent';
import { BASE_URL } from '../config/constant';
import getCandidates from '../redux/action/candidate/getCandidates';
import getVoters from '../redux/action/voter/getVoters';
import postVoter from '../redux/action/voter/postVoter';

function Voting() {
  const candidateState = useSelector((state) => state.candidate);
  const userState = useSelector((state) => state.user);
  const voterState = useSelector((state) => state.voter);

  const [currentVoter, setCurrentVoter] = React.useState(null);

  React.useEffect(() => {
    if (voterState.voter) {
      setCurrentVoter(voterState.voter);
    }
  }, [voterState]);

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
      if (!voterState.data) {
        dispatch(getVoters());
      }
    }
    return () => {
      render.current = false;
    };
  }, [dispatch, voterState]);

  const voteHandler = (e, candidate) => {
    e.preventDefault();
    const date = new Date(Date.now());
    const currentUser = userState.data;


    if(currentUser.role_id === "99") return;

    const payload = {
      candidate,
      token: currentUser.member.token,
      name: currentUser.member.name,
      email: currentUser.email,
      occupation: currentUser.member.occupation,
      periode: currentUser.member.periode,
      createdAt: `${date.getDate()}-${
        date.getMonth() + 1
      }-${date.getFullYear()} ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`,
      updatedAt: null,
    };

    dispatch(postVoter(payload));
  };

  const voterGroupByCandidate = React.useMemo(() => {
    const candidates = {};
    if (voterState.data) {
      voterState.data
        .map((voter) => {
          candidates[voter.candidate] = 0;
          return voter;
        })
        .reduce((_acc, item) => {
          candidates[item.candidate] += 1;
        }, 0);
    }
    return candidates;
  }, [voterState]);

  return (
    <div>
      {candidateState.loading ||
        (voterState.loading && (
         <LoadingComponent />
        ))}
      {!candidateState.loading && !voterState.loading && !userState.loading && (
        <div>
          <div className="my-2">
            <ClockComponent />
            <div className="py-2">
              <span className="text-lg font-bold text-blue-800">
                Total Suara Masuk : {voterState.data && voterState.data.length}
              </span>
            </div>
          </div>

          {(voterState.error &&
            voterState.message.includes('voter not found')) ||
          !currentVoter ? (
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
          ) : (
            <div className="my-12">
              <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-8">
                {
                  candidateState.data && candidateState.data.map((candidate,index) => {
                    return(
                      <div className="rounded shadow-lg" key={index}>
                      <div className="h-56">
                        <div className=" w-full h-full bg-blue-800">
                          <img
                            src={`${BASE_URL}assets/image/maskot.png`}
                            alt="logo himsi kla"
                            className="object-contain w-full h-full"
                          />
                        </div>
                      </div>
                      <div>
                        <div className="flex justify-center -mt-16">
                          <img
                            src={candidate.image ?? 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1200px-No_image_available.svg.png'}
                            alt="profile"
                            className="w-28 h-w-28 object-contain rounded-full border-4 border-white"
                          />
                        </div>
                        <div className="p-4 text-center flex flex-col space-y-4 mb-4">
                          <h5 className="text-lg font-bold text-blue-800 capitalize">{candidate.name}</h5>
                          <div>
                            <span className="text-md text-gray-400 py-1 px-3 border-2 shadow rounded-full border-blue-800">{voterGroupByCandidate[candidate.name]}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    )
                  })
                }
              
              </div>
            </div>
          )}
        </div>
      )}
    </div>
  );
}

export default Voting;
