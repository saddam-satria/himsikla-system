import React from 'react';

function Voting() {
  return (
    <div>
      <div className="grid grid-cols-1 gap-8">
        {[1, 2, 3, 4].map((item) => {
          return (
            <div className="flex justify-between items-center" key={item}>
              <img
                src="https://cdn0-production-images-kly.akamaized.net/e3RkQl8koPGNOhDvC6HNf14-XqI=/640x640/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/4086985/original/021883000_1657675968-131934218_679092246308460_2005924033613967069_n.jpg"
                alt="profile"
                className="w-16 h-w-16 object-contain rounded-full"
              />
              <div className="mx-3">
                <h5 className="text-md lg:text-lg font-bold text-blue-800">
                  Nama Kandidat
                </h5>
                <span className="text-sm text-gray-400">Jabatan</span>
              </div>
              <div className="ml-auto">
                <button className="px-6 rounded-md py-1 bg-blue-800 text-white hover:bg-blue-600">
                  vote
                </button>
              </div>
            </div>
          );
        })}
      </div>
    </div>
  );
}

export default Voting;
