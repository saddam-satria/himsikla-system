import React from 'react';
import CardComponent from '../components/CardComponent';
import ClockComponent from '../components/ClockComponent';

function Voting() {
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
          return <CardComponent key={item} buttonText={'pilih'} />;
        })}
      </div>
    </div>
  );
}

export default Voting;
