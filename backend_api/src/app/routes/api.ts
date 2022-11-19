import { Router } from 'express';
import authController from '../controllers/authController';
import userController from '../controllers/userController';
import WelcomeController from '../controllers/welcomeController';
import isAdmin from '../middlewares/isAdmin';
import isAuth from '../middlewares/isAuth';

const router = Router();

router.get('/', (req, res) => WelcomeController.get(req, res));
router
  .route('/users')
  .get(isAuth, isAdmin, (req, res) => userController.get(req, res));
router
  .route('/user/:id')
  .get(isAuth, isAdmin, (req, res) => userController.getUser(req, res));
router.route('/login').post((req, res) => authController.login(req, res));

router
  .route('/me')
  .post(isAuth, (req, res) => authController.getCurrentUser(req, res));

export default router;
