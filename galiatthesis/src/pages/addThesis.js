import { Component } from "react";
import $ from 'jquery';
import GlobalContext from '../globalContext';
import { Stack } from "@mui/material";
import SelectWithButtons from "../formComponents/selectWithButtons";
import ControlledDropdown from "../formComponents/controlledDropdown";
import FileUploader from "../formComponents/fileUploader";

class AddThesis extends Component {
    constructor(props) {
        super(props);
        this.state = {
            courses: [],
            class: '',
            course_type: '',
            course: '',
            file: null
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
            <Stack alignItems="center" spacing={2} width="100%">
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
                    onChange={ (e) => this.setState({ course_type: e.currentTarget.value, course: '' }) }
                    disabled={ this.state.class === '' }
                    />
                <ControlledDropdown
                    name="course"
                    value={ this.state.course }
                    options={ this.state.courses }
                    label_key="title"
                    value_key="title"
                    control_key="course_type"
                    control_field={ this.state.course_type }
                    onChange={ (e) => this.setState({ course: e.target.value }) }
                    label="Corso di laurea"
                    />
                <FileUploader
                    name="thesis"
                    disabled={ this.state.course === '' }
                    onChange={(e) => this.setState({ file: e.target.files[0] }) }
                    />
            </Stack>
        )
    }

}

AddThesis.contextType = GlobalContext;

export default AddThesis;