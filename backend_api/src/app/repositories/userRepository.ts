import prisma from '../config/prisma';

class UserRepository {
  private userEntity = prisma.user;
  private result: any;
  public async findAll(page = 1, take = 10) {
    const pagination = (page - 1) * take;
    this.result = {
      data: await this.userEntity.findMany({
        take,
        skip: pagination,
        where: {
          role_id: {
            not: 99,
          },
        },
        select: {
          email: true,
          gender: true,
          university: true,
          role: {
            select: {
              roleName: true,
            },
          },
          member: {
            select: {
              image: true,
              name: true,
              token: true,
              nim: true,
              address: true,
              periode: true,
              occupation: true,
              status: true,
              phoneNumber: true,
            },
          },
        },
      }),
      count: await this.userEntity.count(),
    };
    return this;
  }
  public getData() {
    return this.result;
  }
}

export default UserRepository;
