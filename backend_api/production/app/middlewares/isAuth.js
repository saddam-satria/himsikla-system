"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const isAuth = (req, res, next) => {
    var _a;
    const headers = req.headers;
    const payload = {
        message: 'AUTH PROTECTION SERVICE',
        status: 'success',
        data: null,
    };
    try {
        let token = headers['authorization'];
        if (!token)
            throw new Error('Token Required');
        token = token.split(' ')[1];
        res.locals.token = token;
        return next();
    }
    catch (error) {
        payload.error = {
            message: error.message,
        };
        payload.status = 'error';
        payload.statusCode = 403;
        return res.status((_a = payload.statusCode) !== null && _a !== void 0 ? _a : 400).json(payload);
    }
};
exports.default = isAuth;
//# sourceMappingURL=isAuth.js.map