"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
class WelcomeController {
    get(_request, response) {
        response.status(200).json({
            message: 'Selamat Datang Di API HIMSI KLA',
            status: 'success',
            owner: 'Divisi Pendidikan HIMSI KLA',
            github: 'https://github.com/HIMSI-KALIABANG',
            instagram: 'https://instagram.com/himsi.kaliabang',
        });
    }
}
exports.default = new WelcomeController();
//# sourceMappingURL=welcomeController.js.map