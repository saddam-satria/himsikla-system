import React, { useRef } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import deleteCandidate from '../../redux/action/candidate/deleteCandidate';
import getCandidates from '../../redux/action/candidate/getCandidates';

const Candidates = () => {
  const candidateState = useSelector((state) => state.candidate);

  const render = useRef(true);

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

  const deleteCandidateByID = (e, id) => {
    e.preventDefault();

    dispatch(deleteCandidate(id));
  };

  return (
    <div>
      {candidateState.loading && (
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
                Email Kandidat
              </th>
              <th scope="col" className="py-3 px-6">
                NIM Kandidat
              </th>
              <th scope="col" className="py-3 px-6">
                Profile
              </th>
              <th scope="col" className="py-3 px-6">
                Action
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
                          'https://cdn0-production-images-kly.akamaized.net/e3RkQl8koPGNOhDvC6HNf14-XqI=/640x640/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/4086985/original/021883000_1657675968-131934218_679092246308460_2005924033613967069_n.jpg'
                        }`}
                        alt="profile"
                        className="w-12 h-w-12 object-contain rounded-full border-4 border-white"
                      />
                    </td>
                    <td className="py-4 px-6 lowercase"> {candidate.email}</td>
                    <td className="py-4 px-6"> {candidate.nim}</td>

                    <td className="py-4 px-6">
                      {candidate.profile ? (
                        `${candidate.profile.slice(0, 10)}...`
                      ) : (
                        <button
                          onClick={(e) => deleteCandidateByID(e, candidate.id)}
                          className="px-6 rounded-md py-1 text-sm bg-blue-800 text-white hover:bg-blue-600 capitalize"
                        >
                          edit
                        </button>
                      )}
                    </td>

                    <td className="py-4 px-6">
                      <button
                        onClick={(e) => deleteCandidateByID(e, candidate.id)}
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
        {candidateState.data && candidateState.data.length < 1 && (
          <div className="flex justify-center border border-gray-200 uppercase">
            <span className="text-md py-4">belum ada kandidat</span>
          </div>
        )}
      </div>
    </div>
  );
};

export default Candidates;
