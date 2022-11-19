import { NextFunction, Request, Response } from 'express';
import { TResponse } from '../types/response';

const isAuth = (req: Request, res: Response, next: NextFunction) => {
  const headers = req.headers;
  const payload: TResponse<any> = {
    message: 'AUTH PROTECTION SERVICE',
    status: 'success',
    data: null,
  };
  try {
    let token = headers['authorization'];
    if (!token) throw new Error('Token Required');

    token = token.split(' ')[1];

    res.locals.token = token;
    return next();
  } catch (error) {
    payload.error = {
      message: error.message,
    };
    payload.status = 'error';
    payload.statusCode = 403;
    return res.status(payload.statusCode ?? 400).json(payload);
  }
};

export default isAuth;
