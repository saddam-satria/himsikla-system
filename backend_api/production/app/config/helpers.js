"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const hash_1 = __importDefault(require("../helpers/hash"));
const jwtHelpers_1 = __importDefault(require("../helpers/jwtHelpers"));
const log_1 = require("../helpers/log");
const helpers = {
    jwt: new jwtHelpers_1.default(),
    hash: new hash_1.default(),
    logger: {
        server: new log_1.ServerLog(),
        database: new log_1.DatabaseLog(),
    },
};
exports.default = helpers;
//# sourceMappingURL=helpers.js.map