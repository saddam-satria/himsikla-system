import React from 'react';
import { useSelector } from 'react-redux';
import {
  Link,
  useLocation,
  useNavigate,
  useSearchParams,
} from 'react-router-dom';
import { BASE_URL } from '../config/constant';

const NavbarComponent = () => {
  const [isNavbarActive, setIsNavbarActive] = React.useState(false);
  const [searchParams] = useSearchParams();

  const stateUser = useSelector((state) => state.user);
  const currentUser = searchParams.get('current_user');

  const navbarAction = (e) => {
    e.preventDefault();

    setIsNavbarActive(!isNavbarActive);
  };

  const menus = [
    {
      display: 'home',
      to: '/',
    },
    {
      display: 'profile',
      to: `/profile?current_user=${currentUser}`,
    },
  ];

  const router = useLocation();
  const navigate = useNavigate();

  const logout = (e) => {
    e.preventDefault();

    try {
      localStorage.removeItem('token');
      window.location.href = '/';
    } catch (error) {
      navigate('/');
    }
  };

  return (
    <div className="fixed w-full top-0 py-2 bg-blue-800 sm:static z-10">
      <div className="container mx-auto px-0 sm:px-4">
        <div className="flex sm:items-center">
          <div className="flex items-center space-x-6 z-10 ml-6 sm:static sm:ml-0 sm:z-0">
            <img
              src={`${BASE_URL}assets/image/logo_himsi.png`}
              className="w-10 h-10 object-contain"
              alt="HIMSI KLA"
            />
            <h6 className="text-lg font-bold text-blue-50 ">E PEMILU</h6>
            <div
              className="flex flex-col space-y-1 sm:hidden"
              onClick={navbarAction}
            >
              {[1, 2, 3].map((item) => {
                return (
                  <div
                    key={item}
                    style={{ padding: '1.5px 10px' }}
                    className="bg-white rounded-xl"
                  ></div>
                );
              })}
            </div>
          </div>
          <div
            className={`${
              isNavbarActive ? 'translate-x-0' : '-translate-x-full'
            } transition-all ease-in-out delay-75 duration-300 fixed bg-blue-800 h-screen w-1/2 sm:translate-x-0 sm:static sm:w-auto sm:h-auto sm:bg-none sm:ml-auto`}
          >
            <div className="flex flex-col mt-24 ml-4 sm:ml-0 sm:mt-0 sm:flex-row space-x-0 space-y-6 sm:space-y-0 sm:space-x-10">
              {menus.map((menu, index) => {
                return (
                  <span
                    key={index}
                    className={`${
                      isNavbarActive ? 'translate-x-0' : '-translate-x-full'
                    } ${
                      !router.pathname.includes('voting') &&
                      menu.display.includes('profile') &&
                      'hidden'
                    } text-white text-sm  capitalize transition-transform ease-in-out delay-150 duration-500 sm:translate-x-0 sm:transition-none`}
                  >
                    <Link to={menu.to}>{menu.display}</Link>
                  </span>
                );
              })}

              {router.pathname.includes('admin') &&
                (!router.pathname.includes('candidates') ? (
                  <Link
                    to={`/admin/candidates?current_user=${currentUser}`}
                    className={`
              } text-white text-sm  capitalize transition-transform ease-in-out delay-150 duration-500 sm:translate-x-0 sm:transition-none`}
                  >
                    daftar kandidat
                  </Link>
                ) : (
                 <>
                  <Link
                    to={`/admin?current_user=${currentUser}`}
                    className={`
              } text-white text-sm  capitalize transition-transform ease-in-out delay-150 duration-500 sm:translate-x-0 sm:transition-none`}
                  >
                    daftar anggota
                  </Link>
                  <Link
                    to={`/admin/voter?current_user=${currentUser}`}
                    className={`
              } text-white text-sm  capitalize transition-transform ease-in-out delay-150 duration-500 sm:translate-x-0 sm:transition-none`}
                  >
                    daftar pemilih
                  </Link>
                 </>
                ))}

              {router.pathname.includes('admin') ||
              (!stateUser.error && stateUser.data) ? (
                <span
                  onClick={logout}
                  className={`
                } text-white text-sm  capitalize transition-transform ease-in-out delay-150 duration-500 sm:translate-x-0 sm:transition-none cursor-pointer`}
                >
                  Logout
                </span>
              ) : (
                ''
              )}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default NavbarComponent;
