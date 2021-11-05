import { CircularProgress, CssBaseline, ThemeProvider } from '@mui/material';
import { Box } from '@mui/system';
import React, { useContext } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Switch, Route } from 'react-router-dom';
import { SnackbarProvider } from 'notistack';

import theme from './theme';
import Layout from './layout';
import DataProvider from './dataProvider';
import ThesisList from './pages/thesisList';
import GlobalContext from './globalContext';
import AddThesis from './pages/addThesis';

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
                <AddThesis />
            </Route>
            <Route path='/about'>
                <a href={ process.env.REACT_APP_API_URL + '../'}>Cockpit</a>
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
            <SnackbarProvider>
                <BrowserRouter basename={ process.env.PUBLIC_URL }>
                    <Layout>
                        <RoutesList />
                    </Layout>
                </BrowserRouter>
            </SnackbarProvider>
            </DataProvider>
        </ThemeProvider>
    </React.StrictMode>,
    document.getElementById('root')
);