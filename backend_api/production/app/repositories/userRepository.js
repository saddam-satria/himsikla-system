"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const prisma_1 = __importDefault(require("../config/prisma"));
class UserRepository {
    constructor() {
        this.userEntity = prisma_1.default.user;
        this.columns = {
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
    }
    findAll(page = 1, take = 10) {
        return __awaiter(this, void 0, void 0, function* () {
            const pagination = (page - 1) * take;
            this.result = {
                data: yield this.userEntity.findMany({
                    take,
                    skip: pagination,
                    where: {
                        role_id: {
                            not: 99,
                        },
                    },
                    select: this.columns,
                }),
                count: yield this.userEntity.count(),
            };
            return this;
        });
    }
    getData() {
        return this.result;
    }
    getUserByPayload(payload) {
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
    getUserByID(id) {
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
    getUserByEmail(email) {
        return this.userEntity.findFirst({
            select: this.columns,
            where: {
                email,
            },
        });
    }
}
exports.default = UserRepository;
//# sourceMappingURL=userRepository.js.map