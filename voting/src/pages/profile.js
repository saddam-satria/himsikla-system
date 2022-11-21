import React from 'react';
import { useSelector } from 'react-redux';

const Profile = () => {
  const [user, setUser] = React.useState(null);
  const userState = useSelector((state) => state.user);
  React.useEffect(() => {
    const currentUser = userState.data;
    setUser(currentUser);
  }, [userState]);

  return (
    <div>
      {user && (
        <div className="grid grid-cols-1 lg:grid-cols-2">
          <div className="flex flex-col space-y-4 rounded-xl shadow-lg p-4 bg-cyan-50">
            <div className="flex my-4 flex-col items-center space-y-2">
              <img
                src={`${
                  user.member.image ??
                  'https://cdn0-production-images-kly.akamaized.net/e3RkQl8koPGNOhDvC6HNf14-XqI=/640x640/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/4086985/original/021883000_1657675968-131934218_679092246308460_2005924033613967069_n.jpg'
                }`}
                alt="profile"
                className="w-28 h-w-28 object-contain rounded-full"
              />
              <div className="flex flex-col space-y-1 items-center">
                <span className="text-lg text-blue-800 font-bold capitalize">
                  {user.member.name}
                </span>
                <span className="text-md text-gray-400 lowercase">
                  {user.email}
                </span>
              </div>
            </div>
            <div className="flex flex-col space-y-4 py-8 px-2">
              <div className="flex flex-col space-y-2">
                <span className="text-md font-bold capitalize text-gray-800">
                  ID member
                </span>
                <span className="py-2 px-4 bg-blue-100 text-gray-500 rounded-md">
                  {user.member.id}
                </span>
              </div>
              <div className="flex flex-col space-y-2">
                <span className="text-md font-bold capitalize text-gray-800">
                  NIM anggota
                </span>
                <span className="py-2 px-4 bg-blue-100 text-gray-500 rounded-md">
                  {user.member.nim}
                </span>
              </div>
              <div className="flex flex-col space-y-2">
                <span className="text-md font-bold capitalize text-gray-800">
                  token anggota
                </span>
                <span className="py-2 px-4 bg-blue-100 text-gray-500 rounded-md">
                  {user.member.token}
                </span>
              </div>
              <div className="flex flex-col space-y-2">
                <span className="text-md font-bold capitalize text-gray-800">
                  jabatan anggota
                </span>
                <span className="py-2 px-4 bg-blue-100 text-gray-500 rounded-md">
                  {user.member.occupation}
                </span>
              </div>
              <div className="flex flex-col space-y-2">
                <span className="text-md font-bold capitalize text-gray-800">
                  periode anggota
                </span>
                <span className="py-2 px-4 bg-blue-100 text-gray-500 rounded-md">
                  {user.member.periode}
                </span>
              </div>
              <div className="flex flex-col space-y-2">
                <span className="text-md font-bold capitalize text-gray-800">
                  alamat anggota
                </span>
                <p className="py-2 px-4 h-24 bg-blue-100 text-gray-500 rounded-md">
                  {user.member.address}
                </p>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default Profile;
