import React from 'react';
import ClockComponent from '../components/ClockComponent';
import { BASE_URL } from '../config/constant';

function Voting() {
  const currentUser = true;
  return (
    <div>
      <div className="my-2">
        <ClockComponent />
        <div className="py-2">
          <span className="text-lg font-bold text-blue-800">
            Total Suara Masuk : 0
          </span>
        </div>
      </div>
      <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-8">
        {[1, 2, 3, 4].map((item) => {
          return (
            <div className="rounded shadow-lg" key={item}>
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
                    src={`${'https://cdn0-production-images-kly.akamaized.net/e3RkQl8koPGNOhDvC6HNf14-XqI=/640x640/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/4086985/original/021883000_1657675968-131934218_679092246308460_2005924033613967069_n.jpg'}`}
                    alt="profile"
                    className="w-28 h-w-28 object-contain rounded-full border-4 border-white"
                  />
                </div>
                <div className="p-4 text-center">
                  <h5 className="text-lg font-bold text-blue-800">
                    Nama Kandidat
                  </h5>
                  <span className="text-md text-gray-400">Jabatan</span>
                </div>
                <div className="flex justify-center py-4">
                  {currentUser ? (
                    <span className="py-2 px-3 rounded-full border-2 border-blue-800">
                      80
                    </span>
                  ) : (
                    <button className="px-6 rounded-md py-1 bg-blue-800 text-white hover:bg-blue-600">
                      Pilih
                    </button>
                  )}
                </div>
              </div>
            </div>
          );
        })}
      </div>
    </div>
  );
}

export default Voting;
