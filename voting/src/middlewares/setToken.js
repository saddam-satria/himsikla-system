import React from 'react';
import { useSelector, useDispatch } from 'react-redux';
import getToken from '../redux/action/user/getToken';

const SetToken = ({ children }) => {
  const render = React.useRef(true);
  const dispatch = useDispatch();
  const userState = useSelector((state) => state.user);
  React.useEffect(() => {
    if (render.current) {
      dispatch(getToken());
    }
    return () => {
      render.current = false;
    };
  }, [dispatch, userState]);

  return children;
};

export default SetToken;
