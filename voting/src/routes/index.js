import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import NavbarComponent from '../components/NavbarComponent';
import Authentication from '../middlewares/authentication';
import Authorization from '../middlewares/authorization';
import GetUser from '../middlewares/getUser';
import SetToken from '../middlewares/setToken';
import Admin from '../pages/admin';
import Homepage from '../pages/homepage';
import Profile from '../pages/profile';
import Voting from '../pages/voting';

export function Routing() {
  return (
    <Router>
      <NavbarComponent />
      <div className="container mx-auto px-2 sm:px-4 mt-28 sm:mt-8 mb-8">
        <Routes>
          <Route
            path="/"
            element={
              <SetToken>
                <Homepage />
              </SetToken>
            }
          />
          <Route
            path="/voting"
            element={
              <GetUser>
                <Authentication>
                  <Voting />
                </Authentication>
              </GetUser>
            }
          />
          <Route
            path="/profile"
            element={
              <GetUser>
                <Authentication>
                  <Profile />
                </Authentication>
              </GetUser>
            }
          />
          <Route
            path="*"
            element={
              <div>
                <span>not found</span>
              </div>
            }
          />
          <Route
            path="/admin"
            element={
              <GetUser>
                <Authorization>
                  <Admin />
                </Authorization>
              </GetUser>
            }
          />
        </Routes>
      </div>
    </Router>
  );
}
