import { Router } from 'express';
import userController from '../controllers/userController';
import WelcomeController from '../controllers/welcomeController';

const router = Router();

router.get('/', (req, res) => WelcomeController.get(req, res));
router.route('/users').get((req, res) => userController.get(req, res));
router.route('/user/:id').get((req, res) => userController.getUser(req, res));

export default router;
