import { combineReducers } from 'redux';
import candidate from './candidate';
import member from './member';
import user from './user';

export const reducers = combineReducers({
  user,
  candidate,
  member,
});
