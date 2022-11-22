import React from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { Link } from 'react-router-dom';
import CardComponent from '../components/CardComponent';
import ModalComponent from '../components/ModalComponent';
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

  const [modalVision, setModalVision] = React.useState(false);

  return (
    <div>
      <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div className="order-2 sm:order-1 w-full h-full flex flex-col space-y-6 py-12">
          <h1 className="text-xl lg:text-4xl leading-none tracking-wider capitalize font-extrabold text-blue-800">
            E-Pemilu HIMSI UBSI DPC Kaliabang
          </h1>
          <span className="text-sm text-gray-400 uppercase">
            pemilihan ketua cabang DPC kaliabang
          </span>
          <p className="text-gray-400 lowercase">
            E Pemilu adalah salah satu dari inovasi yang dilakukan oleh divisi
            pendidikan sebagai alat bantu berupa media digital untuk membantu
            setiap proses / kegiatan yang akan dilaksanakan oleh{' '}
            <span className="uppercase">HIMSI KLA</span> E pemilu juga merupakan
            bagian dari himsi kla smart system yaitu sistem yang dimiliki oleh
            <span className="uppercase"> HIMSI KLA</span>
          </p>
        </div>
        <div className="w-full h-full order-1 sm:order-2">
          <img
            src={`${BASE_URL}assets/image/undraw_instant_analysis_re_mid5.svg`}
            alt="election day"
            className="w-full h-full lg:h-96 object-contain"
          />
        </div>
      </div>

      <section className="mb-32 md:mb-36">
        <div className="py-8">
          <h5 className="text-blue-800 font-bold text-xl">Calon Kandidat</h5>
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-8">
          {[1, 2, 3, 4].map((item) => {
            return (
              <CardComponent
                key={item}
                buttonText={'Profile'}
                buttonClick={() => setModalVision(true)}
              />
            );
          })}
        </div>
        <ModalComponent header active={modalVision} setActive={setModalVision}>
          <div className="py-2 flex flex-col space-y-2">
            <span className="text-md text-blue-600 font-bold uppercase">
              Visi
            </span>
            <p className="text-sm text-gray-500 text-justify">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi
              earum dignissimos reiciendis, provident, officiis minima hic
              placeat minus excepturi est sed quisquam ea beatae eveniet
              voluptatem, aperiam repellat sint culpa.
            </p>
          </div>
        </ModalComponent>
      </section>

      <section className="my-16 lg:my-0">
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div className="order-2 sm:order-1 w-full h-full flex flex-col space-y-6 py-12">
            <h3 className="text-xl lg:text-3xl capitalize font-extrabold text-blue-800">
              Voting Sekarang !!!
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
                <div className="flex flex-col space-y-4">
                  <div>
                    {' '}
                    <Link
                      to={`/voting?current_user=${currentUser}`}
                      className="px-6 rounded-md py-1 bg-blue-800 text-white hover:bg-blue-600"
                    >
                      ke halaman pemilu
                    </Link>
                  </div>
                  <div>
                    <Link
                      to={`/admin?current_user=${currentUser}`}
                      className="px-6 rounded-md py-1 bg-blue-800 text-white hover:bg-blue-600"
                    >
                      ke halaman admin
                    </Link>
                  </div>
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
                    type="password"
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
