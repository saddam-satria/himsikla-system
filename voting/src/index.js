import React from 'react';
import { createRoot } from 'react-dom/client';
import App from './App';
import './index.scss';
import ReduxProvider from './redux';

const container = document.getElementById('root');
const root = createRoot(container);

root.render(
  <ReduxProvider>
    <App />
  </ReduxProvider>
);
