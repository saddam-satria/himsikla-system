import React from 'react';
import { useDispatch } from 'react-redux';
import { useNavigate, useSearchParams } from 'react-router-dom';
import getUser from '../redux/action/user/getUser';

const GetUser = ({ children }) => {
  const [searchParams] = useSearchParams();

  const currentUser = searchParams.get('current_user');
  const navigate = useNavigate();
  const render = React.useRef(true);
  const dispatch = useDispatch();

  React.useEffect(() => {
    if (render) {
      if (!currentUser) return navigate('/');
    }

    return () => {
      render.current = false;
    };
  }, [navigate, currentUser]);

  React.useEffect(() => {
    if (render) {
      dispatch(getUser(currentUser));
    }

    return () => {
      render.current = false;
    };
  }, [dispatch, currentUser]);

  return children;
};

export default GetUser;
