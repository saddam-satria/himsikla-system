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
const constant_1 = require("../config/utils/constant");
const userRepository_1 = __importDefault(require("../repositories/userRepository"));
class UserController {
    constructor() {
        this.userRepository = new userRepository_1.default();
    }
    get(req, res) {
        var _a, _b, _c;
        return __awaiter(this, void 0, void 0, function* () {
            const request = req.query;
            const payload = {
                message: 'GET ALL USER',
                status: 'success',
                data: null,
            };
            const { page, take, query } = request;
            try {
                if (query) {
                    const { message, success, data } = yield this.getUserByPayload(query);
                    payload.error = undefined;
                    payload.message = 'GET USER BY EMAIL, NAME, TOKEN, PERIODE';
                    payload.request = query;
                    payload.status = 'success';
                    payload.totalData = undefined;
                    payload.nextPage = undefined;
                    payload.nextPage = undefined;
                    if (data.length < 1) {
                        payload.statusCode = 404;
                        throw new Error('User Or Member Not Found');
                    }
                    const user = data.map((user) => {
                        return Object.assign(Object.assign({}, user), { member: Object.assign(Object.assign({}, user.member), { image: user.member.image
                                    ? `${constant_1.HIMSI_KLA_MEMBER_PROFILE}${user.member.image}`
                                    : null }) });
                    });
                    payload.data = user;
                    if (!success) {
                        if (message && message.toLowerCase().includes('no user found')) {
                            payload.statusCode = 404;
                        }
                        throw new Error(message);
                    }
                    return res.status((_a = payload.statusCode) !== null && _a !== void 0 ? _a : 200).json(payload);
                }
                if (!page) {
                    throw new Error('Required Page');
                }
                const takeData = take ? parseInt(take) : 10;
                if (parseInt(page) < 1)
                    throw new Error('page must be greter than 0');
                let users = (yield this.userRepository.findAll(parseInt(page), parseInt(takeData.toString()))).getData();
                const totalData = users.count;
                const totalPage = totalData / takeData;
                if (parseInt(page) > Math.round(totalPage)) {
                    throw new Error('this is the last page');
                }
                users = users.data.map((user) => {
                    return Object.assign(Object.assign({}, user), { member: Object.assign(Object.assign({}, user.member), { image: user.member.image
                                ? `${constant_1.HIMSI_KLA_MEMBER_PROFILE}${user.member.image}`
                                : null }) });
                });
                payload.nextPage =
                    parseInt(page) >= Math.round(totalPage)
                        ? undefined
                        : parseInt(page) + 1;
                payload.prevPage =
                    parseInt(page) <= 1
                        ? undefined
                        : parseInt(page) - 1;
                payload.totalData = users.length;
                payload.totalQuery = totalData;
                payload.data = users;
                return res.status((_b = payload.statusCode) !== null && _b !== void 0 ? _b : 200).json(payload);
            }
            catch (error) {
                payload.status = 'error';
                payload.error = {
                    message: error.message,
                };
                payload.data = null;
                payload.prevPage = undefined;
                payload.nextPage = undefined;
                payload.totalData = undefined;
                return res.status((_c = payload.statusCode) !== null && _c !== void 0 ? _c : 400).json(payload);
            }
        });
    }
    getUserByPayload(payload) {
        return __awaiter(this, void 0, void 0, function* () {
            try {
                const user = yield this.userRepository.getUserByPayload(payload);
                return {
                    success: true,
                    message: null,
                    data: user,
                };
            }
            catch (error) {
                return {
                    success: false,
                    message: error.message,
                    data: null,
                };
            }
        });
    }
    getUser(req, res) {
        var _a, _b, _c;
        return __awaiter(this, void 0, void 0, function* () {
            const payload = {
                message: 'GET USER BY ID OR MEMBER ID',
                status: 'success',
                data: null,
            };
            const { id } = req.params;
            try {
                if (!id)
                    throw new Error('user ID required');
                const data = yield this.userRepository.getUserByID(id);
                const user = Object.assign(Object.assign({}, data), { member: Object.assign(Object.assign({}, data.member), { image: ((_a = data.member) === null || _a === void 0 ? void 0 : _a.image)
                            ? `${constant_1.HIMSI_KLA_MEMBER_PROFILE}${data.member.image}`
                            : null }) });
                payload.data = user;
                return res.status((_b = payload.statusCode) !== null && _b !== void 0 ? _b : 200).json(payload);
            }
            catch (error) {
                payload.status = 'error';
                payload.error = {
                    message: error.message,
                };
                payload.data = null;
                return res.status((_c = payload.statusCode) !== null && _c !== void 0 ? _c : 400).json(payload);
            }
        });
    }
}
exports.default = new UserController();
//# sourceMappingURL=userController.js.map