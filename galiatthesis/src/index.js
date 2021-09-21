import { Button, Card, CssBaseline, Paper, ThemeProvider } from '@mui/material';
import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Switch, Route } from 'react-router-dom';

import theme from './theme';
import { router_basename } from './config';
import Layout from './layout';

ReactDOM.render(
    <React.StrictMode>
        <ThemeProvider theme={ theme }>
            <CssBaseline/>
            <BrowserRouter basename={ router_basename }>
                <Switch>
                    <Route path='*'>
                        <Layout >
                            Home page
                            <Paper>Questa è una paper</Paper>
                            <Button variant="outlined">Button outlined</Button>
                            <Button variant="text">Button text</Button>
                            <Button variant="contained">Button contained</Button>
                            <Card>Questa è una card</Card>
                        </Layout>
                    </Route>
                </Switch>
            </BrowserRouter>
        </ThemeProvider>
    </React.StrictMode>,
    document.getElementById('root')
);