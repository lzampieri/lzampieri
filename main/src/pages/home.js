import React from "react";
import { Typography } from '@material-ui/core';
import { withRouter } from "react-router";

import Layout from "./layout";

class Home extends React.Component {

    render() {
        return (
            <Layout
                pre_menu={<Typography variant="h3" color='secondary'>lzampieri</Typography>}>
                { this.props.location.pathname }
            </Layout>
        );
    }
}

export default withRouter(Home);