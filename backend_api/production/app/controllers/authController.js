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
const jwtHelpers_1 = __importDefault(require("../helpers/jwtHelpers"));
const userRepository_1 = __importDefault(require("../repositories/userRepository"));
class AuthController {
    constructor() {
        this.userRepository = new userRepository_1.default();
    }
    login(req, res) {
        var _a, _b;
        return __awaiter(this, void 0, void 0, function* () {
            const { email, token } = req.body;
            const payload = {
                message: 'LOGIN SERVICE',
                status: 'success',
                data: null,
            };
            try {
                if (!email || !token)
                    throw new Error('Invalid Request Body');
                const user = yield this.userRepository.getUserByEmail(email);
                if (!user)
                    throw new Error('Email Or Token Error');
                if (user.member && user.member.token !== token)
                    throw new Error('Email Or Token Error');
                if (user.role_id === BigInt(99) && token !== constant_1.ADMIN_TOKEN)
                    throw new Error('Email Or Token Error');
                const jwtPayload = {
                    id: user.id,
                };
                const jwtHelper = new jwtHelpers_1.default();
                payload.data = jwtHelper.generateToken(jwtPayload, constant_1.SECRET_KEY);
                payload.error = undefined;
                return res.status((_a = payload.statusCode) !== null && _a !== void 0 ? _a : 200).json(payload);
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
                return res.status((_b = payload.statusCode) !== null && _b !== void 0 ? _b : 400).json(payload);
            }
        });
    }
    getCurrentUser(_req, res) {
        var _a, _b, _c;
        return __awaiter(this, void 0, void 0, function* () {
            const token = res.locals.token;
            const payload = {
                message: 'SESSION SERVICE',
                status: 'success',
                data: null,
            };
            try {
                if (!token)
                    throw new Error('Need A Token');
                const jwtHelper = new jwtHelpers_1.default();
                const verifiedToken = jwtHelper.verifyToken(token, constant_1.SECRET_KEY);
                const id = verifiedToken.id;
                const data = yield this.userRepository.getUserByID(id);
                const user = Object.assign(Object.assign({}, data), { member: Object.assign(Object.assign({}, data.member), { image: ((_a = data.member) === null || _a === void 0 ? void 0 : _a.image)
                            ? `${constant_1.HIMSI_KLA_MEMBER_PROFILE}${data.member.image}`
                            : null }) });
                payload.error = undefined;
                payload.data = user;
                if (!user) {
                    payload.statusCode = 404;
                    throw new Error('User Not Found');
                }
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
}
exports.default = new AuthController();
//# sourceMappingURL=authController.js.map