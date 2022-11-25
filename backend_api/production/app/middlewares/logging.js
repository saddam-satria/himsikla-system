"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.logging = void 0;
const helpers_1 = __importDefault(require("../config/helpers"));
const logging = (request, _response, next) => {
    helpers_1.default.logger.server.setLog('info', `request ${request.protocol} ${request.originalUrl} ${request.method.toUpperCase()}`, `header: content-type(${request.header('Content-Type')}) agent(${request.header('user-agent')}) auth(${request.headers.authorization ? request.headers.authorization : 'No Auth'})`);
    next();
};
exports.logging = logging;
//# sourceMappingURL=logging.js.map