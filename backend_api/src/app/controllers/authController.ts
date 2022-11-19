import { Request, Response } from 'express';
import {
  ADMIN_TOKEN,
  HIMSI_KLA_MEMBER_PROFILE,
  SECRET_KEY,
} from '../config/utils/constant';
import JwtHelper from '../helpers/jwtHelpers';
import UserRepository from '../repositories/userRepository';
import { TResponse } from '../types/response';

class AuthController {
  private userRepository: UserRepository;
  public constructor() {
    this.userRepository = new UserRepository();
  }
  public async login(req: Request, res: Response) {
    const { email, token } = req.body;
    const payload: TResponse<any> = {
      message: 'LOGIN SERVICE',
      status: 'success',
      data: null,
    };

    try {
      if (!email || !token) throw new Error('Invalid Request Body');

      const user = await this.userRepository.getUserByEmail(email as string);
      if (!user) throw new Error('Email Or Token Error');

      if (user.member && user.member.token !== (token as string))
        throw new Error('Email Or Token Error');

      if (user.role_id === BigInt(99) && (token as string) !== ADMIN_TOKEN)
        throw new Error('Email Or Token Error');

      const jwtPayload = {
        id: user.id,
      };

      const jwtHelper = new JwtHelper();
      payload.data = jwtHelper.generateToken(jwtPayload, SECRET_KEY as string);

      payload.error = undefined;
      return res.status(payload.statusCode ?? 200).json(payload);
    } catch (error) {
      payload.status = 'error';
      payload.error = {
        message: error.message,
      };
      payload.data = null;
      payload.prevPage = undefined;
      payload.nextPage = undefined;
      payload.totalData = undefined;
      return res.status(payload.statusCode ?? 400).json(payload);
    }
  }
  public async getCurrentUser(_req: Request, res: Response) {
    const token = res.locals.token;
    const payload: TResponse<any> = {
      message: 'SESSION SERVICE',
      status: 'success',
      data: null,
    };
    try {
      if (!token) throw new Error('Need A Token');

      const jwtHelper = new JwtHelper();
      const verifiedToken: any = jwtHelper.verifyToken(
        token,
        SECRET_KEY as string
      );

      const id = verifiedToken.id;

      const data = await this.userRepository.getUserByID(id as string);

      if (data.role_id === BigInt(99)) {
        payload.statusCode = 401;
        throw new Error('User Not Found');
      }

      const user = {
        ...data,
        member: {
          ...data.member,
          image: data.member?.image
            ? `${HIMSI_KLA_MEMBER_PROFILE}${data.member.image}`
            : null,
        },
      };

      payload.error = undefined;
      payload.data = user;
      if (!user) {
        payload.statusCode = 404;
        throw new Error('User Not Found');
      }

      return res.status(payload.statusCode ?? 200).json(payload);
    } catch (error) {
      payload.status = 'error';
      payload.error = {
        message: error.message,
      };
      payload.data = null;
      payload.prevPage = undefined;
      payload.nextPage = undefined;
      payload.totalData = undefined;
      return res.status(payload.statusCode ?? 400).json(payload);
    }
  }
}

export default new AuthController();
