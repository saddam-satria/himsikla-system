import React from 'react';
import { useSelector } from 'react-redux';
import { useDispatch } from 'react-redux';
import { Link } from 'react-router-dom';
import { BASE_URL } from '../config/constant';
import loginReduxAction from '../redux/action/user/login';

function Homepage() {
  const [payload, setPayload] = React.useState({
    email: '',
    token: '',
  });
  const dispatch = useDispatch();
  const userState = useSelector((state) => state.user);
  const currentUser = userState.data;

  const startVoting = (e) => {
    e.preventDefault();

    dispatch(loginReduxAction(payload.email, payload.token));
  };

  return (
    <div>
      <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div className="order-2 sm:order-1 w-full h-full flex flex-col space-y-6 py-12">
          <h3 className="text-xl lg:text-3xl capitalize font-extrabold text-blue-800">
            E-Pemilu HIMSI UBSI Kaliabang
          </h3>
          <span className="text-sm text-gray-400 uppercase">
            pemilihan ketua cabang DPC kaliabang
          </span>
          {currentUser && (
            <div className="flex flex-col space-y-4">
              <p className="text-gray-400 capitalize">
                pilih ketua dpc kaliabang sesuai dengan pilihan anda sendiri,
                setiap account hanya bisa di gunakan sekali saja
              </p>
              <div>
                <Link
                  to={'/'}
                  className="px-6 rounded-md py-1 bg-blue-800 text-white hover:bg-blue-600"
                >
                  ke halaman pemilu
                </Link>
              </div>
            </div>
          )}
          {!currentUser && (
            <div>
              <div className="flex flex-col space-y-4">
                <input
                  type="text"
                  placeholder="masukan email anda"
                  className="py-2 px-4 bg-blue-50 text-black rounded-lg focus:outline-none hover:outline-none hover:border-none focus:border-none"
                  onChange={(e) => {
                    setPayload({ ...payload, email: e.target.value });
                  }}
                />
                <input
                  type="text"
                  placeholder="masukan token anda"
                  className="py-2 px-4 bg-blue-50 text-black rounded-lg focus:outline-none hover:outline-none hover:border-none focus:border-none"
                  onChange={(e) => {
                    setPayload({ ...payload, token: e.target.value });
                  }}
                />
                <div className="ml-auto">
                  <button
                    onClick={startVoting}
                    className="px-6 rounded-md py-1 bg-blue-800 text-white hover:bg-blue-600"
                  >
                    Mulai
                  </button>
                </div>
              </div>
            </div>
          )}
        </div>
        <div className="w-full h-full order-1 sm:order-2">
          <img
            src={`${BASE_URL}assets/image/election.svg`}
            alt="election day"
            className="w-full h-full lg:h-1/2 object-contain"
          />
        </div>
      </div>
    </div>
  );
}

export default Homepage;
