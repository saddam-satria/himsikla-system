import { NextFunction, Request, Response } from 'express';
import { SECRET_KEY } from '../config/utils/constant';
import JwtHelper from '../helpers/jwtHelpers';
import UserRepository from '../repositories/userRepository';
import { TResponse } from '../types/response';

const isAdmin = async (_req: Request, res: Response, next: NextFunction) => {
  const payload: TResponse<any> = {
    message: 'AUTH PROTECTION SERVICE',
    status: 'success',
    data: null,
  };
  try {
    const token = res.locals.token;

    if (!token) {
      payload.statusCode = 403;
      throw new Error('Token Required');
    }

    const jwtHelper = new JwtHelper();
    const decodedToken: any = jwtHelper.verifyToken(
      token,
      SECRET_KEY as string
    );

    const userRepository = new UserRepository();
    const user = await userRepository.getUserByID(decodedToken.id);

    const isAdmin = user.role_id === BigInt(99);

    if (!isAdmin) {
      payload.statusCode = 401;
      throw new Error("You're Not An Admin");
    }

    return next();
  } catch (error) {
    payload.error = {
      message: error.message,
    };
    payload.status = 'error';

    if (error.message) {
      if (error.message.includes('jwt malformed')) {
        payload.statusCode = 404;
      }
      if (error.message.includes('authorization required')) {
        payload.statusCode = 401;
      }
      if (error.message.includes('jwt expired')) {
        payload.statusCode = 403;
      }
      if (error.message.includes('invalid token')) {
        payload.statusCode = 406;
      }
      if (error.message.includes('jwt must be provided')) {
        payload.statusCode = 401;
      }
    }

    return res.status(payload.statusCode ?? 400).json(payload);
  }
};

export default isAdmin;
