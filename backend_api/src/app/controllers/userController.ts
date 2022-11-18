import { Request, Response } from 'express';
import { HIMSI_KLA_MEMBER_PROFILE } from '../config/utils/constant';
import UserRepository from '../repositories/userRepository';
import { TResponse } from '../types/response';

class UserController {
  private userRepository: UserRepository;
  constructor() {
    this.userRepository = new UserRepository();
  }

  public async get(req: Request, res: Response) {
    const query = req.query;
    const payload: TResponse<any> = {
      message: 'GET ALL USER',
      status: 'success',
      data: null,
    };

    const { page, take, param } = query;

    try {
      if (param) {
        const { message, success, data } = await this.getUserByPayload(
          param as string
        );

        payload.data = data;
        payload.error = undefined;
        payload.message = 'GET USER BY EMAIL, NAME, TOKEN';
        payload.request = param as string;
        payload.status = 'success';
        payload.totalData = undefined;
        payload.nextPage = undefined;
        payload.nextPage = undefined;

        if (!success) {
          if (message && message.toLowerCase().includes('no user found')) {
            payload.statusCode = 404;
          }
          throw new Error(message as string);
        }

        return res.status(payload.statusCode ?? 200).json(payload);
      }

      if (!page) {
        throw new Error('Required Page');
      }

      const takeData = take ? parseInt(take as string) : 10;

      if (parseInt(page as string) < 1)
        throw new Error('page must be greter than 0');
      let users = (
        await this.userRepository.findAll(
          parseInt(page as string),
          parseInt(takeData.toString())
        )
      ).getData();

      const totalData = users.count as number;

      const totalPage = totalData / takeData;

      if (parseInt(page as string) > Math.round(totalPage)) {
        throw new Error('this is the last page');
      }

      users = users.data.map((user: any) => {
        return {
          ...user,
          member: {
            ...user.member,
            image: user.member.image
              ? `${HIMSI_KLA_MEMBER_PROFILE}${user.member.image}`
              : null,
          },
        };
      });
      payload.nextPage =
        parseInt(page as string) >= Math.round(totalPage)
          ? undefined
          : parseInt(page as string) + 1;

      payload.prevPage =
        parseInt(page as string) <= 1
          ? undefined
          : parseInt(page as string) - 1;
      payload.totalData = users.length;
      payload.data = users;

      return res.status(payload.statusCode ?? 200).json(payload);
    } catch (error) {
      payload.status = 'error';
      payload.error = {
        message: error.message,
      };
      return res.status(payload.statusCode ?? 400).json(payload);
    }
  }
  private async getUserByPayload(payload: string): Promise<{
    success: boolean;
    message: null | string;
    data: any;
  }> {
    try {
      const user = await this.userRepository.getUserByPayload(payload);
      return {
        success: true,
        message: null,
        data: user,
      };
    } catch (error) {
      return {
        success: false,
        message: error.message,
        data: null,
      };
    }
  }
}

export default new UserController();
