import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import NavbarComponent from '../components/NavbarComponent';
import Authentication from '../middlewares/authentication';
import GetUser from '../middlewares/getUser';
import SetToken from '../middlewares/setToken';
import Homepage from '../pages/homepage';
import Voting from '../pages/voting';

export function Routing() {
  return (
    <Router>
      <NavbarComponent />
      <div className="container mx-auto px-2 sm:px-4 mt-32 sm:mt-8">
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
        </Routes>
      </div>
    </Router>
  );
}
