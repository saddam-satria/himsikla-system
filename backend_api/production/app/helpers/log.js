"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.DatabaseLog = exports.ServerLog = void 0;
const logger_1 = __importDefault(require("../config/logger"));
const path_1 = require("path");
const fs_1 = __importDefault(require("fs"));
const constant_1 = require("../config/utils/constant");
const writeLogToTxt = (fileName, data) => {
    if (!fs_1.default.existsSync((0, path_1.join)(constant_1.BASE_PATH, 'logs'))) {
        fs_1.default.mkdir((0, path_1.join)(constant_1.BASE_PATH, 'logs'), (error) => {
            if (error)
                throw error;
        });
    }
    fs_1.default.appendFile((0, path_1.join)(constant_1.BASE_PATH, 'logs', `${fileName}.txt`), `${new Date().toISOString()}\t${data.join('\t')}\n`, (error) => {
        if (error)
            throw error;
    });
};
class ServerLog extends logger_1.default {
    setLog(...logs) {
        this.emit('server', ...logs);
    }
    getLog() {
        this.on('server', (...logs) => {
            writeLogToTxt('server-log', logs);
        });
    }
}
exports.ServerLog = ServerLog;
class DatabaseLog extends logger_1.default {
    setLog(...logs) {
        this.emit('database', ...logs);
    }
    getLog() {
        this.on('database', (...logs) => {
            writeLogToTxt('database-log', logs);
        });
    }
}
exports.DatabaseLog = DatabaseLog;
//# sourceMappingURL=log.js.map