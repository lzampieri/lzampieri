import { Box, CircularProgress } from "@material-ui/core";
import React from "react"

import CourseCard from "../components/course_card";
import { api_url } from "../config";

import Layout from "./layout";

class Didactic extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            courses: []
        }
    }

    componentDidMount() {
        this.downloadData();
    }

    async downloadData() {
        let response = await fetch(api_url + 'collections/get/courses');
        let data = await response.json();
        let courses = data.entries;
        courses.forEach( (c,i,array) => array[i].attachments = [] );

        let response2 = await fetch(api_url + 'collections/get/attachments');
        let attch = await response2.json();
        attch.entries.forEach( (a) => {
            courses.some( (c,i,array) => {
                if( c._id === a.course._id ) {
                    array[i].attachments.push( a );
                    return true;
                }
                return false;
                // Some si arresta quando trova un true
            } )
        })

        this.setState({ courses: courses });
    }
    
    render() {
        return (
            <Layout>
                <Box display="flex" flexDirection="column" alignItems="center" width="100%">
                    { this.state.courses.map( cs => <CourseCard key={cs._id} course={cs} /> ) }
                    { this.state.courses.length === 0 && <CircularProgress variant="indeterminate" color="primary" key={-1} /> }
                </Box>
            </Layout>
        );
    }
}

export default Didactic;