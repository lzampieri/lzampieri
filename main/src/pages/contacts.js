import { Box, Button, Typography } from "@material-ui/core";
import React from "react";
import MailIcon from '@material-ui/icons/Mail';

import Layout from "./layout";
import { api_url } from "../config";

class Contacts extends React.Component {

    render() {
        return (
            <Layout>
                <Box display="flex" justifyContent="center" py={3}>
                    <MailIcon />
                    <Typography variant="overline">  lzampieri@altervista.org</Typography>
                </Box>
                <Box display="flex" justifyContent="center" py={3}>
                    <Button compnent="a" href={ api_url.replace("/api/","") } variant="outlined">Cockpit</Button>
                </Box>
            </Layout>
        );
    }
}

export default Contacts;