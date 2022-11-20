import React, { useState, useEffect } from 'react';
import axios from '../config/axios';

function Homepage() {
  const [counter, setCounter] = useState(0);

  const plus = () => {
    setCounter(counter + 1);
  };

  useEffect(() => {
    const fetchUser = async () => {
      const users = await axios.get('/');

      console.log(users);
    };

    fetchUser();
  }, []);

  return (
    <div className="container">
      <div className="flex">
        <img alt="" src="react-icon.png" className="react-logo" />
        <div style={{ padding: '10px 0px' }} className="flex">
          <span
            style={{
              color: 'white',
              fontSize: '36px',
            }}
          >
            edit src/app.jsx
          </span>
          <span
            style={{
              color: 'white',
              fontSize: '18px',
              padding: '5px 0px',
              textTransform: 'lowercase',
            }}
          >
            Created by <span style={{ fontWeight: 700 }}>Saddam</span>
          </span>
          <span style={{ color: 'white', fontSize: '32px' }}>{counter}</span>
          <div
            style={{
              position: 'absolute',
              right: 0,
              bottom: 0,
              padding: '35px',
            }}
          >
            <button
              type="submit"
              onClick={plus}
              style={{ padding: '15px ', cursor: 'pointer' }}
            >
              +
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}

export default Homepage;
