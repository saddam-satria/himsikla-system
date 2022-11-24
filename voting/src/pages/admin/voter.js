import React, { useRef } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import getVoters from '../../redux/action/voter/getVoters';

const Voter = () => {
  const voterState = useSelector((state) => state.voter);

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



  return (
    <div>
      {voterState.loading && (
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
                Nama Pemilih
              </th>
              <th scope="col" className="py-3 px-6">
                Token Kandidat
              </th>
              <th scope="col" className="py-3 px-6">
                Nama Kandidat
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
