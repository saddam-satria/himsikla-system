"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const jsonwebtoken_1 = require("jsonwebtoken");
class JwtHelper {
    generateToken(payload, secretKey, options) {
        return (0, jsonwebtoken_1.sign)(payload, secretKey, options);
    }
    verifyToken(token, secretKey, options) {
        return (0, jsonwebtoken_1.verify)(token, secretKey, options);
    }
    decodeToken(token, options) {
        return (0, jsonwebtoken_1.decode)(token, options);
    }
}
exports.default = JwtHelper;
//# sourceMappingURL=jwtHelpers.js.map