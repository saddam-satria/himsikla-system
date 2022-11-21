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
      <h5 className="text-blue-800 font-bold text-xl">Profile Pemilih</h5>
      {user && (
        <div className="grid grid-cols-1 lg:grid-cols-2">
          <div className="flex flex-col space-y-4">
            <div className="flex my-4">
              <img
                src={`${
                  user.member.image ??
                  'https://cdn0-production-images-kly.akamaized.net/e3RkQl8koPGNOhDvC6HNf14-XqI=/640x640/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/4086985/original/021883000_1657675968-131934218_679092246308460_2005924033613967069_n.jpg'
                }`}
                alt="profile"
                className="w-28 h-w-28 object-contain rounded-full"
              />
            </div>
            <div className="flex flex-col space-y-4">
              <span className="py-2 px-4 bg-blue-800 text-white rounded-md">
                {user.member.id}
              </span>
              <span className="py-2 px-4 bg-blue-800 text-white rounded-md">
                {user.email}
              </span>
              <span className="py-2 px-4 bg-blue-800 text-white rounded-md">
                {user.member.name}
              </span>
              <span className="py-2 px-4 bg-blue-800 text-white rounded-md">
                {user.member.token}
              </span>
              <span className="py-2 px-4 bg-blue-800 text-white rounded-md">
                {user.member.occupation}
              </span>
              <span className="py-2 px-4 bg-blue-800 text-white rounded-md">
                {user.member.periode}
              </span>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default Profile;
