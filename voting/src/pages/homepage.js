import React, { useState, useEffect } from 'react';
import axios from '../config/axios';

function Homepage() {
  const [counter, setCounter] = useState(0);

  useEffect(() => {
    const fetchUser = async () => {
      const users = await axios.get('/');

      console.log(users);
    };

    fetchUser();
  }, []);

  return (
    <div>
      <h5 className="uppercase text-blue-300">Selamat Datang</h5>
    </div>
  );
}

export default Homepage;
