import { Request, Response } from 'express';

class WelcomeController {
  public get(_request: Request, response: Response) {
    response.status(200).json({
      message: 'Selamat Datang Di API HIMSI KLA',
      status: 'success',
      owner: 'Divisi Pendidikan HIMSI KLA',
      github: 'https://github.com/HIMSI-KALIABANG',
      instagram: 'https://instagram.com/himsi.kaliabang',
    });
  }
}

export default new WelcomeController();
