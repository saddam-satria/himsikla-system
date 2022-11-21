import React from 'react';
import { BASE_URL } from '../config/constant';

function Voting() {
  return (
    <div>
      <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div className="order-2 sm:order-1 w-full h-full flex flex-col space-y-6 py-12">
          <h1 className="text-xl lg:text-4xl leading-none tracking-wider capitalize font-extrabold text-blue-800">
            E-Pemilu HIMSI UBSI DPC Kaliabang
          </h1>
          <span className="text-sm text-gray-400 uppercase">
            pemilihan ketua cabang DPC kaliabang
          </span>
          <p className="text-gray-400 lowercase">
            E Pemilu adalah salah satu dari inovasi yang dilakukan oleh divisi
            pendidikan sebagai alat bantu berupa media digital untuk membantu
            setiap proses / kegiatan yang akan dilaksanakan oleh{' '}
            <span className="uppercase">HIMSI KLA</span> E pemilu juga merupakan
            bagian dari himsi kla smart system yaitu sistem yang dimiliki oleh
            <span className="uppercase">HIMSI KLA</span>
          </p>
        </div>
        <div className="w-full h-full order-1 sm:order-2">
          <img
            src={`${BASE_URL}assets/image/maskot.png`}
            alt="election day"
            className="w-full h-full lg:h-96 object-contain"
          />
        </div>
      </div>
    </div>
  );
}

export default Voting;
