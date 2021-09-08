import { CssBaseline, ThemeProvider } from '@material-ui/core';
import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Switch, Route } from 'react-router-dom';

import Home from './pages/home';
import Projects from './pages/projects';
import theme from './theme';
import { router_basename } from './config';
import Contacts from './pages/contacts';

ReactDOM.render(
    <React.StrictMode>
        <ThemeProvider theme={ theme }>
            <CssBaseline/>
            <BrowserRouter basename={ router_basename }>
                <Switch>
                    <Route path='/projects'>
                        <Projects />
                    </Route>
                    <Route path='/contacts'>
                        <Contacts />
                    </Route>
                    <Route path='*'>
                        <Home />
                    </Route>
                </Switch>
            </BrowserRouter>
        </ThemeProvider>
    </React.StrictMode>,
    document.getElementById('root')
);