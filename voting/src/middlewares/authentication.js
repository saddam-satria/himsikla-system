import React from 'react';
import { useSelector } from 'react-redux';
import { useNavigate } from 'react-router-dom';

const Authentication = ({ children }) => {
  const render = React.useRef(true);
  const userState = useSelector((state) => state.user);
  const navigate = useNavigate();

  React.useEffect(() => {
    if (render) {
      if (userState.error) {
        return navigate('/');
      }
    }

    return () => {
      render.current = false;
    };
  }, [navigate, userState]);

  return children;
};

export default Authentication;
