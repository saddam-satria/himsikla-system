import React from 'react';
import { useSelector } from 'react-redux';

const Admin = () => {
  const memberState = useSelector((state) => state.member);

  return (
    <div className="overflow-x-auto relative">
      <table className="w-full text-sm text-left text-gray-500 ">
        <thead className="text-xs uppercase bg-blue-800 text-white ">
          <tr>
            <th scope="col" className="py-3 px-6">
              Nama Anggota
            </th>
            <th scope="col" className="py-3 px-6">
              Email Anggota
            </th>
            <th scope="col" className="py-3 px-6">
              NIM Anggota
            </th>
            <th scope="col" className="py-3 px-6">
              Action
            </th>
          </tr>
        </thead>
        <tbody>
          {memberState.data &&
            memberState.data.map((user, index) => {
              return (
                <tr key={index} className="bg-white border-b ">
                  <th
                    scope="row"
                    className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap capitalize"
                  >
                    {user.member.name}
                  </th>
                  <td className="py-4 px-6 lowercase"> {user.email}</td>
                  <td className="py-4 px-6"> {user.member.nim}</td>
                  <td className="py-4 px-6">
                    <button className="px-6 rounded-md py-1 text-sm bg-blue-800 text-white hover:bg-blue-600 capitalize">
                      kandidat
                    </button>
                  </td>
                </tr>
              );
            })}
        </tbody>
      </table>
    </div>
  );
};

export default Admin;
