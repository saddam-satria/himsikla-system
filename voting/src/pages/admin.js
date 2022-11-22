import React, { useState, useMemo, useRef } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { useSearchParams } from 'react-router-dom';
import getCandidates from '../redux/action/candidate/getCandidates';
import getMemberByQuery from '../redux/action/member/getMemberByQuery';
import getMembers from '../redux/action/member/getMembers';

const Admin = () => {
  const memberState = useSelector((state) => state.member);
  const [page, setPage] = useState(1);
  const [take, setTake] = useState(10);
  const [query, setQuery] = useState('');
  const [searchParams] = useSearchParams();
  const token = searchParams.get('current_user');

  const timeout = useRef(null);
  const render = useRef(true);

  const endPage = useMemo(
    () => Math.round(memberState.totalData / take),
    [memberState, take]
  );
  const pages = useMemo(
    () => [10, 20, 30, 40, 50, memberState.totalData],
    [memberState]
  );
  const dispatch = useDispatch();

  React.useEffect(() => {
    setQuery('');
    dispatch(getMembers(token, page, take));
  }, [page, token, dispatch, take]);

  const findMemberByEnter = (e) => {
    e.preventDefault();

    if (e.key === 'Enter') {
      const { value } = e.target;

      if (!value) return '';

      setQuery(value);
    }
  };

  const findMemberDebounce = (e) => {
    timeout.current = setTimeout(() => {
      setQuery(e.target.value);
    }, 300);
  };

  React.useEffect(() => {
    if (query) {
      dispatch(getMemberByQuery(token, query));
    } else {
      dispatch(getMembers(token, 1, 10));
    }

    return () => {
      clearTimeout(timeout.current);
    };
  }, [query, dispatch, token]);

  React.useEffect(() => {
    if (render.current) {
      dispatch(getCandidates());
    }
    return () => {
      render.current = false;
    };
  }, [dispatch]);

  const selectMemberToCandidate = (e, data) => {
    e.preventDefault();
    const { email, gender, member } = data;
    const { nim, occupation, address, periode, phoneNumber } = member;
    const payload = {
      email,
      nim,
      occupation,
      address,
      periode,
      phone: phoneNumber,
      gender,
      likes: 0,
    };

    console.log(payload);
  };

  return (
    <div>
      {memberState.loading && (
        <div className="fixed left-0 top-0 z-10 h-screen w-screen">
          <div className="flex flex-col space-y-2 justify-center h-full w-full items-center">
            <img
              src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRL2tq0IANwwvpD-dJ-YD8Zbe0Xeriw2h-mdw&usqp=CAU"
              alt="circle loading"
              className="w-36 h-36 object-contain"
            />
            <span className="text-sm capitalize">tunggu sebentar</span>
          </div>
        </div>
      )}
      <div className="mb-2">
        <div className="relative">
          <div className="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg
              aria-hidden="true"
              className="w-5 h-5 text-gray-500 dark:text-gray-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
              ></path>
            </svg>
          </div>
          <input
            onKeyUp={findMemberByEnter}
            onChange={findMemberDebounce}
            type="search"
            id="default-search"
            className="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 "
            placeholder="cari anggota"
            required
          />
        </div>
      </div>

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
                      <button
                        onClick={(e) => selectMemberToCandidate(e, user)}
                        className="px-6 rounded-md py-1 text-sm bg-blue-800 text-white hover:bg-blue-600 capitalize"
                      >
                        kandidat
                      </button>
                    </td>
                  </tr>
                );
              })}
          </tbody>
        </table>
        {memberState.error &&
          memberState.message.includes('User Or Member Not Found') && (
            <div className="flex justify-center border border-gray-200">
              <span className="text-md py-4">user tidak ditemukan</span>
            </div>
          )}
      </div>
      <div className="py-2 flex items-center">
        <div className="flex flex-col space-y-1">
          <select
            id="countries"
            value={take}
            onChange={(e) => setTake(e.target.value)}
            className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
          >
            {pages.map((pageNumber, index) => {
              return (
                <option value={pageNumber} key={index}>
                  {pageNumber === memberState.totalData ? 'All' : pageNumber}
                </option>
              );
            })}
          </select>
          {!query && (
            <span className="text-sm text-gray-400 lowercase">
              page {page} dari {endPage}
            </span>
          )}
        </div>
        {!query && (
          <div className="flex space-x-1 ml-auto">
            {page > 1 && (
              <button
                onClick={() => setPage(page - 1)}
                className="text-md font-bold py-1 px-4 rounded-md bg-blue-500 text-white"
              >
                {'<'}
              </button>
            )}
            {page < endPage && (
              <button
                onClick={() => setPage(page + 1)}
                className="text-md font-bold py-1 px-4 rounded-md bg-blue-500 text-white"
              >
                {'>'}
              </button>
            )}
          </div>
        )}
      </div>
    </div>
  );
};

export default Admin;
