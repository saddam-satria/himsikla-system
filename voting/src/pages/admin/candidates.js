import React, { useRef } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import deleteCandidate from '../../redux/action/candidate/deleteCandidate';
import getCandidates from '../../redux/action/candidate/getCandidates';
import updateProfile from '../../redux/action/candidate/updateProfile';

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

  const [profile, setProfile] = React.useState('');
  const [formEditProfile, setFormEditProfile] = React.useState(false);
  const [selectedCandidate, setSelectedCandidate] = React.useState('');

  const editProfile = (e, currentProfile, id) => {
    e.preventDefault();

    setFormEditProfile(true);
    setProfile(currentProfile);
    setSelectedCandidate(id);
  };

  const updateProfileHandler = (e) => {
    e.preventDefault();
    const payload = {
      id: selectedCandidate,
      profile,
    };

    dispatch(updateProfile(payload.id, payload.profile));
    setProfile('');
    setFormEditProfile(false);
    setSelectedCandidate('');
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
                Edit Profile
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
                          'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1200px-No_image_available.svg.png'
                        }`}
                        alt="profile"
                        className="w-12 h-w-12 object-contain rounded-full border-4 border-white"
                      />
                    </td>
                    <td className="py-4 px-6 lowercase"> {candidate.email}</td>
                    <td className="py-4 px-6"> {candidate.nim}</td>
                    <td className="py-4 px-6">
                      {' '}
                      {candidate.profile ? candidate.profile : '-'}
                    </td>

                    <td className="py-4 px-6">
                      <button
                        onClick={(e) =>
                          editProfile(e, candidate.profile, candidate.id)
                        }
                        className="px-6 rounded-md py-1 text-sm bg-blue-800 text-white hover:bg-blue-600 capitalize"
                      >
                        edit
                      </button>
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
      {formEditProfile && (
        <div className="my-32 grid grid-cols-1 lg:grid-cols-2">
          <div className="flex flex-col space-y-4">
            <label
              htmlFor="profile"
              className="block mb-2 text-sm font-medium text-gray-900"
            >
              Profile
            </label>
            <textarea
              type="text"
              id="profile"
              className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              placeholder="tuliskan biografi singkat"
              rows={3}
              cols={3}
              onChange={(e) => setProfile(e.target.value)}
              value={profile}
            />

            <div className="flex">
              <div className="ml-auto">
                <button
                  onClick={updateProfileHandler}
                  className="px-6 rounded-md py-1 text-sm bg-blue-800 text-white hover:bg-blue-600 capitalize"
                >
                  edit
                </button>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default Candidates;
