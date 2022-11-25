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
const isAdmin = (_req, res, next) => __awaiter(void 0, void 0, void 0, function* () {
    var _a;
    const payload = {
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
        const jwtHelper = new jwtHelpers_1.default();
        const decodedToken = jwtHelper.verifyToken(token, constant_1.SECRET_KEY);
        const userRepository = new userRepository_1.default();
        const user = yield userRepository.getUserByID(decodedToken.id);
        const isAdmin = user.role_id === BigInt(99);
        if (!isAdmin) {
            payload.statusCode = 401;
            throw new Error("You're Not An Admin");
        }
        return next();
    }
    catch (error) {
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
        return res.status((_a = payload.statusCode) !== null && _a !== void 0 ? _a : 400).json(payload);
    }
});
exports.default = isAdmin;
//# sourceMappingURL=isAdmin.js.map