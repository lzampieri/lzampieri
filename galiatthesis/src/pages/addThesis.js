import { Component, Fragment } from "react";
import $ from 'jquery';
import GlobalContext from '../globalContext';
import { Box } from "@mui/material";
import SelectWithButtons from "../formComponents/selectWithButtons";
import ControlledDropdown from "../formComponents/controlledDropdown";

class AddThesis extends Component {
    constructor(props) {
        super(props);
        this.state = {
            courses: [],
            class: '',
            course_type: '',
            course: ''
        }
    }

    async componentDidMount() {
        let courses = (await $.get( process.env.PUBLIC_URL + "/courses.json" ));
        this.setState({ courses: courses } );
    }

    validator(values) {
        return {};
    }

    async save(values) {
    }

    render () {
        return (
            <Box display="flex" flexDirection="column" alignItems="center" gap={2} width="100%">
                <SelectWithButtons
                    name="class"
                    options={ this.context.classes }
                    label_key="name"
                    value_key="acronym"
                    value={ this.state.class }
                    onChange={ (e) => this.setState({ class: e.currentTarget.value }) }
                    />
                <SelectWithButtons
                    name="course_type"
                    options={ this.context.types }
                    label_key="name"
                    value_key="acronym"
                    value={ this.state.course_type }
                    onChange={ (e) => this.setState({ course_type: e.currentTarget.value }) }
                    />
                <ControlledDropdown
                    name="course"
                    options={ this.state.courses }
                    label_key="title"
                    value_key="title"
                    control_key="course_type"
                    control_field={ this.state.course_type }
                    label="Corso di laurea"
                    />
            </Box>
        )
    }

}

AddThesis.contextType = GlobalContext;

export default AddThesis;