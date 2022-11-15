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
      message: 'get ALL USER',
      status: 'success',
      data: null,
    };

    const { page, take } = query;

    try {
      if (parseInt(page as string) < 1)
        throw new Error('page must be greter than 0');
      let users = (
        await this.userRepository.findAll(parseInt(page as string))
      ).getData();

      const totalData = users.count as number;
      const takeData = take ? parseInt(take as string) : 10;
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
      payload.totalData = users.length;
      payload.data = users;
      return res.status(200).json(payload);
    } catch (error) {
      payload.status = 'error';
      payload.error = {
        message: error.message,
      };
      return res.status(200).json(payload);
    }
  }
}

export default new UserController();
