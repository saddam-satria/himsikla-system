import React, { useRef } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import BarChartComponent from '../../components/BarchartComponent';
import LoadingComponent from '../../components/LoadingComponent';
import getCandidates from '../../redux/action/candidate/getCandidates';
import deleteVoter from '../../redux/action/voter/deleteVoter';
import getVoters from '../../redux/action/voter/getVoters';

const Voter = () => {
  const voterState = useSelector((state) => state.voter);
  const candidateState = useSelector((state) => state.candidate);
  const render = useRef(true);

  const dispatch = useDispatch();

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

  const deleteVoterHandler = (e, voterID) => {
    e.preventDefault();

    dispatch(deleteVoter(voterID));
  };

  const [candidateNames, count] = React.useMemo(() => {
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
    return [Object.keys(candidates), candidates];
  }, [voterState]);

  const [labels, dataset] = React.useMemo(() => {
    return [
      candidateNames.map((name) => name),
      candidateNames.map((name) => count[name]),
    ];
  }, [candidateNames, count]);

  return (
    <div>
      {voterState.data && voterState.data.length > 0 && (
        <div className="my-8 grid grid-cols-1 lg:grid-cols-2 gap-4">
          <div className="overflow-x-auto relative">
            <table className="w-full text-sm text-left text-gray-500 ">
              <thead className="text-xs uppercase bg-blue-800 text-white ">
                <tr>
                  <th scope="col" className="py-3 px-6">
                    Nama Kandidat
                  </th>
                  <th scope="col" className="py-3 px-6">
                    Foto Kandidat
                  </th>
                  <th scope="col" className="py-3 px-6">
                    Total Suara
                  </th>
                </tr>
              </thead>
              <tbody>
                {candidateState.data &&
                  candidateState.data.map((candidate, index) => {
                    return (
                      <tr key={index} className="bg-white border-b ">
                        <th
                          scope="row"
                          className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap capitalize"
                        >
                          {candidate.name}
                        </th>
                        <td className="py-4 px-6 lowercase">
                          <img
                            src={`${
                              candidate.image ??
                              'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1200px-No_image_available.svg.png'
                            }`}
                            alt="profile"
                            className="w-12 h-w-12 object-contain rounded-full border-4 border-white"
                          />
                        </td>
                        <td className="py-4 px-6 lowercase">
                          {count[candidate.name] ?? 0}
                        </td>
                      </tr>
                    );
                  })}
              </tbody>
            </table>
            {candidateState.data && candidateState.data.length < 1 && (
              <div className="flex justify-center border border-gray-200 uppercase">
                <span className="text-md py-4">belum ada kandidat</span>
              </div>
            )}
          </div>
          <BarChartComponent labels={labels} rawData={dataset} />
        </div>
      )}
      {voterState.loading && <LoadingComponent />}
      <div className="overflow-x-auto relative">
        <table className="w-full text-sm text-left text-gray-500 ">
          <thead className="text-xs uppercase bg-blue-800 text-white ">
            <tr>
              <th scope="col" className="py-3 px-6">
                Nama Pemilih
              </th>
              <th scope="col" className="py-3 px-6">
                Token Kandidat
              </th>
              <th scope="col" className="py-3 px-6">
                Nama Kandidat
              </th>
              <th scope="col" className="py-3 px-6">
                Action
              </th>
            </tr>
          </thead>
          <tbody>
            {voterState.data &&
              voterState.data.map((voter, index) => {
                return (
                  <tr key={index} className="bg-white border-b ">
                    <th
                      scope="row"
                      className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap capitalize"
                    >
                      {voter.name}
                    </th>

                    <td className="py-4 px-6 lowercase"> {voter.token}</td>
                    <td className="py-4 px-6"> {voter.candidate}</td>
                    <td className="py-4 px-6">
                      <button
                        onClick={(e) => deleteVoterHandler(e, voter.id)}
                        className="px-6 rounded-md py-1 text-sm bg-red-800 text-white hover:bg-red-600 capitalize"
                      >
                        delete
                      </button>
                    </td>
                  </tr>
                );
              })}
          </tbody>
        </table>
        {voterState.data && voterState.data.length < 1 && (
          <div className="flex justify-center border border-gray-200 uppercase">
            <span className="text-md py-4">data belum tersedia</span>
          </div>
        )}
      </div>
    </div>
  );
};

export default Voter;
