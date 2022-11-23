import React from 'react';
import { useDispatch, useSelector } from 'react-redux';
import CardComponent from '../components/CardComponent';
import ClockComponent from '../components/ClockComponent';
import getCandidates from '../redux/action/candidate/getCandidates';

function Voting() {
  const candidateState = useSelector((state) => state.candidate);
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
              />
            );
          })}
      </div>
    </div>
  );
}

export default Voting;
