import { CssBaseline, ThemeProvider } from '@material-ui/core';
import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter } from 'react-router-dom';

import Home from './pages/home';
import theme from './theme';

ReactDOM.render(
    <React.StrictMode>
        <ThemeProvider theme={ theme }>
            <CssBaseline/>
            <BrowserRouter>
                <Home />
            </BrowserRouter>
        </ThemeProvider>
    </React.StrictMode>,
    document.getElementById('root')
);