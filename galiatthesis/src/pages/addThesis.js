import { Component, Fragment } from "react";
import $ from 'jquery';

class AddThesis extends Component {
    constructor(props) {
        super(props);
        this.state = {
            courses: []
        }
    }

    async componentDidMount() {
        let courses = (await $.get( process.env.PUBLIC_URL + "/courses.json" ));
        this.setState({ courses: courses } );
    }

    render () {
        return (
            <Fragment>
                { this.state.courses.map( c => JSON.stringify(c) ) }
            </Fragment>
        )
    }
}

export default AddThesis;