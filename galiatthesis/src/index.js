import { CssBaseline, ThemeProvider } from '@material-ui/core';
import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Switch, Route } from 'react-router-dom';

import theme from './theme';
import { router_basename } from './config';

ReactDOM.render(
    <React.StrictMode>
        <ThemeProvider theme={ theme }>
            <CssBaseline/>
            <BrowserRouter basename={ router_basename }>
                <Switch>
                    <Route path='*'>
                        Home page
                    </Route>
                </Switch>
            </BrowserRouter>
        </ThemeProvider>
    </React.StrictMode>,
    document.getElementById('root')
);