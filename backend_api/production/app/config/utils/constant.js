"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.ADMIN_TOKEN = exports.SECRET_KEY = exports.HIMSI_KLA_MEMBER_PROFILE = exports.BASE_ASSET = exports.BASE_PATH = exports.ASSET_URL = exports.BASE_URL = exports.PORT = void 0;
const path_1 = __importDefault(require("path"));
const dotenv_1 = __importDefault(require("dotenv"));
dotenv_1.default.config();
exports.PORT = process.env.PORT || 5000;
exports.BASE_URL = `http://localhost:${exports.PORT}`;
exports.ASSET_URL = `${exports.BASE_URL}/assets`;
exports.BASE_PATH = path_1.default.resolve(__dirname, '..', '..', '..', '..');
exports.BASE_ASSET = path_1.default.join(exports.BASE_PATH, 'public');
exports.HIMSI_KLA_MEMBER_PROFILE = 'https://himsikaliabang.com/assets/member/profile/';
exports.SECRET_KEY = process.env.SECRET_KEY;
exports.ADMIN_TOKEN = process.env.ADMIN_TOKEN;
//# sourceMappingURL=constant.js.map