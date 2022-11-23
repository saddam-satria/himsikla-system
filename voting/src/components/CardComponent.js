import React from 'react';
import { BASE_URL } from '../config/constant';

const CardComponent = ({
  image,
  buttonClick,
  buttonText,
  name,
  periode,
  occupation,
}) => {
  return (
    <div className="rounded shadow-lg">
      <div className="h-56">
        <div className=" w-full h-full bg-blue-800">
          <img
            src={`${BASE_URL}assets/image/maskot.png`}
            alt="logo himsi kla"
            className="object-contain w-full h-full"
          />
        </div>
      </div>
      <div>
        <div className="flex justify-center -mt-16">
          <img
            src={`${
              image ??
              'https://cdn0-production-images-kly.akamaized.net/e3RkQl8koPGNOhDvC6HNf14-XqI=/640x640/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/4086985/original/021883000_1657675968-131934218_679092246308460_2005924033613967069_n.jpg'
            }`}
            alt="profile"
            className="w-28 h-w-28 object-contain rounded-full border-4 border-white"
          />
        </div>
        <div className="p-4 text-center flex flex-col mb-4">
          <h5 className="text-lg font-bold text-blue-800 capitalize">
            {name ?? 'John Doe'}
          </h5>
          <span className="text-md text-gray-400">
            {periode ?? '2021-2022'}
          </span>
          <span className="text-md text-gray-400">{occupation ?? 'ketua'}</span>
        </div>
        <div className="flex justify-center py-4">
          <button
            onClick={buttonClick}
            className="px-6 rounded-md py-1 bg-blue-800 text-white hover:bg-blue-600"
          >
            {buttonText}
          </button>
        </div>
      </div>
    </div>
  );
};

export default CardComponent;
