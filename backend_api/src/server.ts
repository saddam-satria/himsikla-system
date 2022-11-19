import express from 'express';
import cors from 'cors';
import dotenv from 'dotenv';
import apiRoutes from './app/routes/api';
import { BASE_ASSET, BASE_URL, PORT } from './app/config/utils/constant';
import helpers from './app/config/helpers';
import { logging } from './app/middlewares/logging';
import prisma from './app/config/prisma';

(() => {
  dotenv.config();
  const app = express();

  app.use(
    cors({
      origin: 'http://localhost:3000',
    })
  );
  app.use(express.json());
  app.use(express.urlencoded({ extended: true }));
  app.use(logging);
  app.use('/assets', express.static(BASE_ASSET));
  // app.use('/api', apiRoutes);
  app.use('/', apiRoutes);

  (BigInt.prototype as any).toJSON = function () {
    return this.toString();
  };

  app.listen(PORT, async () => {
    try {
      helpers.logger.server.setLog(
        'info',
        `server started on ${BASE_URL}`,
        'success'
      );
      await prisma.$connect();
      prisma.$on('query', (e: any) => {
        console.log('query', e.query);
        console.log('duration', e.duration);
      });
      console.log('database connected');
    } catch (error) {
      helpers.logger.server.setLog('info', `${error.message}`, 'error');
      await prisma.$disconnect();
    }
  });

  helpers.logger.server.getLog();
  helpers.logger.database.getLog();
})();
