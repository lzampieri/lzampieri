import { Box, CircularProgress } from "@material-ui/core";
import React from "react";
import { withRouter } from "react-router";


import ProjectCard from "../components/project_card";
import { api_url } from "../config";

import Layout from "./layout";

class Projects extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            projects: []
        }
    }

    componentDidMount() {
        this.downloadData();
    }

    async downloadData() {
        let response = await fetch(api_url + 'collections/get/projects');
        let data = await response.json();
        console.log(data);
        this.setState({ projects: data.entries });
    }
    
    render() {
        return (
            <Layout>
                <Box display="flex" flexWrap="wrap" justifyContent="center">
                    { this.state.projects.map( pr => <ProjectCard project={pr} /> ) }
                    { this.state.projects.length === 0 && <CircularProgress variant="indeterminate" color="primary" /> }
                </Box>
            </Layout>
        );
    }
}

export default Projects;