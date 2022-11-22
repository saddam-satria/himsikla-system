import React from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { useNavigate, useSearchParams } from 'react-router-dom';
import getMembers from '../redux/action/member/getMembers';

const Authorization = ({ children }) => {
  const render = React.useRef(true);
  const dispatch = useDispatch();
  const [searchParams] = useSearchParams();
  const navigate = useNavigate();
  const currentUser = searchParams.get('current_user');

  const memberState = useSelector((state) => state.member);

  React.useEffect(() => {
    if (render) {
      dispatch(getMembers(currentUser, 1));
    }

    return () => {
      render.current = false;
    };
  }, [currentUser, dispatch]);

  React.useEffect(() => {
    if (render) {
      if (memberState.error && memberState.message.includes('not admin'))
        return navigate('/');
    }

    return () => {
      render.current = false;
    };
  }, [navigate, memberState]);

  return children;
};

export default Authorization;
