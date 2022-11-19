import prisma from '../config/prisma';

class UserRepository {
  private userEntity = prisma.user;
  private result: any;
  private columns = {
    email: true,
    gender: true,
    university: true,
    id: true,
    role_id: true,
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
        id: true,
      },
    },
  };
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
        select: this.columns,
      }),
      count: await this.userEntity.count(),
    };
    return this;
  }
  public getData() {
    return this.result;
  }
  public getUserByPayload(payload: string) {
    return this.userEntity.findMany({
      select: this.columns,
      where: {
        OR: [
          {
            email: {
              equals: payload,
            },
          },
          {
            member: {
              token: {
                equals: payload,
              },
            },
          },
          {
            member: {
              name: {
                contains: payload,
              },
            },
          },
          {
            member: {
              periode: {
                equals: payload,
              },
            },
          },
        ],
        AND: {
          role_id: {
            not: 99,
          },
        },
      },
    });
  }
  public getUserByID(id: string) {
    return this.userEntity.findFirstOrThrow({
      where: {
        OR: [
          {
            id,
          },
          {
            member: {
              id,
            },
          },
        ],
      },
      select: this.columns,
    });
  }
  public getUserByEmail(email: string) {
    return this.userEntity.findFirst({
      select: this.columns,
      where: {
        email,
      },
    });
  }
}

export default UserRepository;
