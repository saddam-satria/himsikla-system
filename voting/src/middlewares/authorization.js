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

  const userState = useSelector((state) => state.user);

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
      if (userState.data && typeof userState.data === "object" &&userState.data.role_id !== "99") return navigate('/');
    }

    return () => {
      render.current = false;
    };
  }, [navigate, userState]);

  return children;
};

export default Authorization;
