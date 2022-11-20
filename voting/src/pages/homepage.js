import React from 'react';
import { useSelector, useDispatch } from 'react-redux';
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
            E-Pemilu HIMSI UBSI DPC Kaliabang
          </h3>
          <span className="text-sm text-gray-400 uppercase">
            pemilihan ketua cabang DPC kaliabang
          </span>
          <p className="text-gray-400 lowercase">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa
            consequuntur quod dolores nam laboriosam earum neque totam, eum ab
            autem voluptatum nisi dolore quasi illo quos soluta iusto saepe
            ullam corrupti architecto, eligendi ad. Voluptate ratione, quis
            exercitationem alias corrupti, laudantium eius placeat ipsam libero
            et doloribus reprehenderit explicabo quia.
          </p>
        </div>
        <div className="w-full h-full order-1 sm:order-2">
          <img
            src={`${BASE_URL}assets/image/maskot.png`}
            alt="election day"
            className="w-full h-full lg:h-96 object-contain"
          />
        </div>
      </div>

      <section>
        <div className="py-8">
          <h5 className="text-blue-800 font-bold text-xl">Calon Kandidat</h5>
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
          {[1, 2, 3, 4].map((item) => {
            return (
              <div className="rounded shadow-lg" key={item}>
                <div className="h-80">
                  <img
                    src={
                      'https://cdn0-production-images-kly.akamaized.net/e3RkQl8koPGNOhDvC6HNf14-XqI=/640x640/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/4086985/original/021883000_1657675968-131934218_679092246308460_2005924033613967069_n.jpg'
                    }
                    className="w-full object-cover h-full object-center"
                    alt="profile"
                  />
                </div>
                <div className="py-8 px-4">
                  <h5 className="text-lg font-bold text-blue-800">
                    Nama Kandidat
                  </h5>
                  <h6 className="text-md text-gray-400">Periode</h6>
                  <span className="text-md text-gray-400">Jabatan</span>
                </div>
              </div>
            );
          })}
        </div>
      </section>

      <section className="my-16 lg:my-0">
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
      </section>
    </div>
  );
}

export default Homepage;
