import { Box, Typography } from "@material-ui/core";
import React from "react";
import MailIcon from '@material-ui/icons/Mail';

import Layout from "./layout";

class Contacts extends React.Component {

    render() {
        return (
            <Layout>
                <Box display="flex" justifyContent="center" py={3}>
                    <MailIcon />
                    <Typography variant="overline">  lzampieri@altervista.org</Typography>
                </Box>
            </Layout>
        );
    }
}

export default Contacts;