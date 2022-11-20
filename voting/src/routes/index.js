import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import NavbarComponent from '../components/NavbarComponent';
import Homepage from '../pages/homepage';

export function Routing() {
  return (
    <Router>
      <NavbarComponent />
      <div className="container mx-auto px-0 sm:px-4 mt-4">
        <Routes>
          <Route path="/" element={<Homepage />} />
        </Routes>
      </div>
    </Router>
  );
}
