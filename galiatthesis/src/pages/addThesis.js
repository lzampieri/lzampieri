import { Component, Fragment } from "react";
import $ from 'jquery';

class AddThesis extends Component {
    constructor(props) {
        super(props);
        this.state = {
            courses: "Loading"
        }
    }

    async componentDidMount() {
        let courses = (await $.get( "collections/get/classes")).entries;
        this.setState({ data: { courses: courses } } );
    }

    render () {
        return (
            <Fragment>
                {process.env.PUBLIC_URL}
                {this.state.courses}
            </Fragment>
        )
    }
}

export default AddThesis;