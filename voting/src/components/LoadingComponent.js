import React from 'react';
import { BASE_URL } from '../config/constant';

const LoadingComponent = () => {
  return (
    <div className="fixed left-0 top-0 z-10 h-screen w-screen">
      <div className="flex flex-col space-y-2 justify-center h-full w-full items-center">
        <img
          src={`${BASE_URL}assets/image/loader.png`}
          alt="circle loading"
          className="w-36 h-36 object-contain animate-spin"
        />
        <span className="text-sm capitalize">tunggu sebentar</span>
      </div>
    </div>
  );
};

export default LoadingComponent;
