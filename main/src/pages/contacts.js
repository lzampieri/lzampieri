import { Box, Button, Typography } from "@material-ui/core";
import React from "react";
import MailIcon from '@material-ui/icons/Mail';

import Layout from "./layout";
import { router_basename } from "../config";

class Contacts extends React.Component {

    render() {
        return (
            <Layout>
                <Box display="flex" justifyContent="center" py={3}>
                    <MailIcon />
                    <Typography variant="overline">  lzampieri@altervista.org</Typography>
                </Box>
                <Box display="flex" justifyContent="center" py={3}>
                    <Button compnent="a" href={ "/" + router_basename + "/cockpit" } variant="outlined">Cockpit</Button>
                </Box>
            </Layout>
        );
    }
}

export default Contacts;