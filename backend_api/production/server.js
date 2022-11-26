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
const express_1 = __importDefault(require("express"));
const cors_1 = __importDefault(require("cors"));
const dotenv_1 = __importDefault(require("dotenv"));
const api_1 = __importDefault(require("./app/routes/api"));
const constant_1 = require("./app/config/utils/constant");
const helpers_1 = __importDefault(require("./app/config/helpers"));
const logging_1 = require("./app/middlewares/logging");
const prisma_1 = __importDefault(require("./app/config/prisma"));
(() => {
    dotenv_1.default.config();
    const app = (0, express_1.default)();
    app.use((0, cors_1.default)({
        origin: ['https://pemilu.himsikaliabang.com', 'http://pemilu.himsikaliabang.com'],
    }));
    app.use(express_1.default.json());
    app.use(express_1.default.urlencoded({ extended: true }));
    app.use(logging_1.logging);
    app.use('/assets', express_1.default.static(constant_1.BASE_ASSET));
    app.use('/', api_1.default);
    BigInt.prototype.toJSON = function () {
        return this.toString();
    };
    app.listen(constant_1.PORT, () => __awaiter(void 0, void 0, void 0, function* () {
        try {
            helpers_1.default.logger.server.setLog('info', `server started on ${constant_1.BASE_URL}`, 'success');
            yield prisma_1.default.$connect();
            prisma_1.default.$on('query', (e) => {
                console.log('query', e.query);
                console.log('duration', e.duration);
            });
            console.log('database connected');
        }
        catch (error) {
            helpers_1.default.logger.server.setLog('info', `${error.message}`, 'error');
            yield prisma_1.default.$disconnect();
        }
    }));
    helpers_1.default.logger.server.getLog();
    helpers_1.default.logger.database.getLog();
})();
//# sourceMappingURL=server.js.map