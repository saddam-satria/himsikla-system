import React from 'react';
import { Link, useLocation } from 'react-router-dom';
import { BASE_URL } from '../config/constant';

const NavbarComponent = () => {
  const [isNavbarActive, setIsNavbarActive] = React.useState(false);

  const navbarAction = (e) => {
    e.preventDefault();

    setIsNavbarActive(!isNavbarActive);
  };

  const menus = [
    {
      display: 'home',
      to: '/',
    },
  ];

  const router = useLocation();

  return (
    <div className="fixed w-full top-0 py-4 bg-blue-800 sm:static">
      <div className="container mx-auto px-0 sm:px-4">
        <div className="flex sm:items-center">
          <div className="flex items-center space-x-6 z-10 ml-6 sm:static sm:ml-0 sm:z-0">
            <img
              src={`${BASE_URL}assets/image/logo_himsi.png`}
              className="w-12 h-12 object-contain"
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
                      router.pathname.includes(menu.to) && 'font-bold'
                    } text-white text-sm  capitalize transition-transform ease-in-out delay-150 duration-500 sm:translate-x-0 sm:transition-none`}
                  >
                    <Link to={menu.to}>{menu.display}</Link>
                    {router.pathname.includes(menu.to) && (
                      <div
                        style={{ padding: '1px' }}
                        className="bg-blue-400 rounded-md hidden sm:block"
                      ></div>
                    )}
                  </span>
                );
              })}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default NavbarComponent;
