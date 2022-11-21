import React from 'react';
import { useSelector } from 'react-redux';
import { useNavigate } from 'react-router-dom';

const Authorization = ({ children }) => {
  const render = React.useRef(true);
  const userState = useSelector((state) => state.user);
  const navigate = useNavigate();

  React.useEffect(() => {
    if (render) {
      const { data } = userState;
      console.log(data);
      if (data.role_id !== 99) return navigate('/voting');
    }

    return () => {
      render.current = false;
    };
  }, [navigate, userState]);

  return children;
};

export default Authorization;
