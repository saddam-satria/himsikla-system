import React from 'react';
import { useDispatch } from 'react-redux';
import getToken from '../redux/action/user/getToken';

const SetToken = ({ children }) => {
  const render = React.useRef(true);

  const dispatch = useDispatch();
  React.useEffect(() => {
    if (render.current) {
      dispatch(getToken());
    }
    return () => {
      render.current = false;
    };
  }, [dispatch]);

  return children;
};

export default SetToken;
