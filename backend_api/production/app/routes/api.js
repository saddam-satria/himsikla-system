"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const express_1 = require("express");
const authController_1 = __importDefault(require("../controllers/authController"));
const userController_1 = __importDefault(require("../controllers/userController"));
const welcomeController_1 = __importDefault(require("../controllers/welcomeController"));
const isAdmin_1 = __importDefault(require("../middlewares/isAdmin"));
const isAuth_1 = __importDefault(require("../middlewares/isAuth"));
const router = (0, express_1.Router)();
router.get('/', (req, res) => welcomeController_1.default.get(req, res));
router
    .route('/users')
    .get(isAuth_1.default, isAdmin_1.default, (req, res) => userController_1.default.get(req, res));
router
    .route('/user/:id')
    .get(isAuth_1.default, isAdmin_1.default, (req, res) => userController_1.default.getUser(req, res));
router.route('/login').post((req, res) => authController_1.default.login(req, res));
router
    .route('/me')
    .post(isAuth_1.default, (req, res) => authController_1.default.getCurrentUser(req, res));
exports.default = router;
//# sourceMappingURL=api.js.map