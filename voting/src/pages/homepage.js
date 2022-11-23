import React from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { Link } from 'react-router-dom';
import validator from 'validator';
import CardComponent from '../components/CardComponent';
import ModalComponent from '../components/ModalComponent';
import { BASE_URL } from '../config/constant';
import getCandidates from '../redux/action/candidate/getCandidates';
import loginReduxAction from '../redux/action/user/login';

function Homepage() {
  const [payload, setPayload] = React.useState({
    email: '',
    token: '',
  });
  const dispatch = useDispatch();
  const userState = useSelector((state) => state.user);
  const candidateState = useSelector((state) => state.candidate);
  const currentUser = userState.data;

  const [errorMessage, setErrorMessage] = React.useState('');

  const startVoting = (e) => {
    e.preventDefault();

    if (!validator.isEmail(payload.email)) {
      setErrorMessage('format email salah');
      setPayload({
        ...payload,
        email: '',
      });
      return;
    }
    dispatch(loginReduxAction(payload.email, payload.token));
    setPayload({
      email: '',
      token: '',
    });
  };

  const timeout = React.useRef(null);

  React.useEffect(() => {
    if (userState.error && userState.message.includes('Email Or Token Error')) {
      setErrorMessage('anggota tidak di temukan');
    }
  }, [userState]);

  React.useEffect(() => {
    timeout.current = setTimeout(() => {
      if (errorMessage) {
        setErrorMessage('');
      }
    }, 600);

    return () => {
      clearTimeout(timeout.current);
    };
  }, [errorMessage]);

  React.useEffect(() => {
    if (!candidateState.data) {
      dispatch(getCandidates());
    }
  }, [dispatch, candidateState]);

  const [modalVision, setModalVision] = React.useState(false);

  const [profileCandidate, setProfile] = React.useState('');

  const profileClick = (e, id) => {
    e.preventDefault();
    setModalVision(!modalVision);

    const { profile } = candidateState.data.filter(
      (candidate) => candidate.id === id
    );
    setProfile(profile);
  };

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
      {candidateState.data && candidateState.data.length < 1 && (
        <div className="flex flex-col space-y-4 my-12 items-center">
          <img
            src={`${BASE_URL}assets/image/undraw_team_up_re_84ok.svg`}
            alt="circle loading"
            className="w-80 h-80 object-contain"
          />
          <span className="text-sm capitalize">belum ada kandidat</span>
        </div>
      )}
      {candidateState.data && candidateState.data.length > 0 && (
        <section className="mb-32 md:mb-36">
          <div className="py-8">
            <h5 className="text-blue-800 font-bold text-xl">Calon Kandidat</h5>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-8">
            {candidateState.data.map((candidate, index) => {
              return (
                <div key={index}>
                  <CardComponent
                    buttonText={'Profile'}
                    buttonClick={() => setModalVision(true)}
                    name={candidate.name}
                    occupation={candidate.occupation}
                    periode={candidate.periode}
                    image={candidate.image}
                  />
                  <ModalComponent
                    header
                    active={modalVision}
                    setActive={(e) => profileClick(e, candidate.id)}
                  >
                    <div className="py-2 flex flex-col space-y-2">
                      <span className="text-md text-blue-600 font-bold uppercase">
                        Profile
                      </span>
                      <p className="text-sm text-gray-500 text-justify">
                        {profileCandidate}
                      </p>
                    </div>
                  </ModalComponent>
                </div>
              );
            })}
          </div>
        </section>
      )}

      <section className="my-16 lg:my-0">
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div className="order-2 sm:order-1 w-full h-full flex flex-col space-y-6 py-12">
            <h3 className="text-xl lg:text-3xl capitalize font-extrabold text-blue-800">
              Voting Sekarang !!!
            </h3>

            <span className="text-sm text-gray-400 uppercase">
              pemilihan ketua cabang DPC kaliabang
            </span>
            {errorMessage && (
              <span className="text-sm text-red-500">{errorMessage}</span>
            )}
            {currentUser && (
              <div className="flex flex-col space-y-4">
                <p className="text-gray-400 capitalize">
                  pilih ketua dpc kaliabang sesuai dengan pilihan anda sendiri,
                  setiap account hanya bisa di gunakan sekali saja
                </p>
                <div className="flex flex-col space-y-4">
                  <div>
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
                    value={payload.email}
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
                    value={payload.token}
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
