import { CircularProgress, CssBaseline, ThemeProvider } from '@mui/material';
import { Box } from '@mui/system';
import React, { useContext } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Switch, Route } from 'react-router-dom';

import theme from './theme';
import { router_basename } from './config';
import Layout from './layout';
import DataProvider from './dataProvider';
import ThesisList from './pages/thesisList';
import GlobalContext from './globalContext';

function RoutesList() {
    if( useContext(GlobalContext).loading )
        return (
            <Box display='flex' justifyContent='center' width='100%' p={3} >
                <CircularProgress />
            </Box>
        )
    return (
        <Switch>
            <Route path='/add'>
                Add stuff
            </Route>
            <Route path='/about'>
                About
            </Route>
            <Route path='*'>
                <ThesisList />
            </Route>
        </Switch>
    );
}

ReactDOM.render(
    <React.StrictMode>
        <ThemeProvider theme={ theme }>
            <CssBaseline/>
            <DataProvider>
                <BrowserRouter basename={ router_basename }>
                    <Layout>
                        <RoutesList />
                    </Layout>
                </BrowserRouter>
            </DataProvider>
        </ThemeProvider>
    </React.StrictMode>,
    document.getElementById('root')
);