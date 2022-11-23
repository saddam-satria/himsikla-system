import React from 'react';

const ModalComponent = ({ children, header, active, setActive }) => {
  return (
    active && (
      <div
        onClick={setActive}
        className="fixed top-0 h-screen z-20 left-0 w-screen bg-gray-800 bg-opacity-50"
      >
        <div className="flex items-center h-full justify-center">
          <div className="w-96 py-3 bg-red-100 mx-4 sm:mx-0 rounded-md transition-transform ease-in-out delay-150 duration-500">
            {header && (
              <div className="flex px-4">
                <div className="ml-auto">
                  <span
                    onClick={setActive}
                    className="font-bold text-lg uppercase text-red-700 cursor-pointer"
                  >
                    x
                  </span>
                </div>
              </div>
            )}
            <div className="py-2 px-4">{children}</div>
          </div>
        </div>
      </div>
    )
  );
};

export default ModalComponent;
