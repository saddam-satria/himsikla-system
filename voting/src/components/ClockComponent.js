import React, { useEffect, useState } from 'react';

const ClockComponent = () => {
  const [clock, setClock] = useState(new Date());

  useEffect(() => {
    setInterval(() => {
      setClock(new Date());
    }, 1000);
  }, []);

  return (
    <div>
      <div className="bg-black w-full h-32 rounded-lg">
        <div className="p-4 flex flex-col h-full">
          <div className="flex">
            <span className="text-white text-lg">Live Preview</span>
            <div className="ml-auto">
              <span className="text-lg text-red-700 font-bold">
                {clock.toLocaleString('id', {
                  month: 'long',
                  day: '2-digit',
                  year: 'numeric',
                })}
              </span>
            </div>
          </div>
          <div className="flex justify-center items-center h-full">
            <span
              className="text-xl xl:text-4xl text-red-700 font-bold"
              style={{ letterSpacing: '8px' }}
            >
              {clock.toLocaleString('En-US', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
              })}
            </span>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ClockComponent;
