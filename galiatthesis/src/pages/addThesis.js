import { Component, Fragment } from "react";
import $ from 'jquery';
import GlobalContext from '../globalContext';
import { Stack } from "@mui/material";
import SelectWithButtons from "../formComponents/selectWithButtons";
import ControlledDropdown from "../formComponents/controlledDropdown";
import FileUploader from "../formComponents/fileUploader";
import MyBackDrop from "../layoutComponents/MyBackDrop";
import CustomTextField from "../formComponents/customTextField";
import { withSnackbar } from "notistack";

class AddThesis extends Component {
    constructor(props) {
        super(props);
        this.state = {
            courses: [],
            class: '',
            course_type_label: '',
            course: '',
            file: null,
            loading: false,
            author: '',
            advisor: ''
        }
    }

    async componentDidMount() {
        let courses = (await $.get( process.env.PUBLIC_URL + "/courses.json" ));
        this.setState({ courses: courses } );
    }

    async uploadForm( thefile ) {
        this.setState({ loading: true });

        try {
            let send_url = process.env.REACT_APP_API_URL + "cockpit/addAssets?token=" + process.env.REACT_APP_API_TOKEN;
            let data = new FormData();
            data.append('files[]', thefile);
            let res = await $.ajax( {
                url: send_url,
                type: 'POST',
                data: data,
                processData: false,
                contentType: false
                } );
            let asset = res.assets[0];
            if( !asset ) throw new Error('Errore nel caricamento del file. Riprova.');

            let thesis_send_url = process.env.REACT_APP_API_URL + "collections/save/thesis?token=" + process.env.REACT_APP_API_TOKEN;
            let thesis_data = {
                class: { _id: this.state.class, link: 'classes'},
                course_type: {_id: this.get_course_type_id( this.state.course_type_label ), link: 'types'},
                course: this.state.course,
                author: this.state.author,
                advisor: this.state.advisor,
                file: asset
            };
            if( this.state.course_type_label === 'SG' )
                thesis_data.course = this.get_class_name( this.state.class );

            console.log( thesis_data );
            
            await $.ajax( {
                url: thesis_send_url,
                type: 'POST',
                data: JSON.stringify( {data: thesis_data} ),
                processData: false,
                contentType: false,
                headers: { 'Content-Type': 'application/json' }
                } );

                this.props.enqueueSnackbar('Tesi salvata!', { variant: 'success' } );
        } catch (e) {
            // Check if the error has a JSON response
            if( e.responseJSON && e.responseJSON.error )
                this.props.enqueueSnackbar(e.responseJSON.error, { variant: 'error' } );
            // Check if the error has a message
            else if( e.message )
                this.props.enqueueSnackbar(e.message, { variant: 'error' } );
            // Otherwise log the error
            else {
                this.props.enqueueSnackbar("Errore generico", { variant: 'error' } );
                console.log(e);
            }
        }

        this.setState({
            class: '',
            course_type: '',
            course: '',
            author: '',
            advisor: '',
            file: null,
            loading: false
        })
    }

    get_course_type_id( course_type ) {
        for( const c of this.context.types ) {
            if( c.acronym === course_type )
                return c._id;
        }
        throw new Error('Errore nella decodifica del tipo di corso');
    }

    get_class_name( class_id ) {
        for( const c of this.context.classes ) {
            if( c._id === class_id )
                return c.name;
        }
        throw new Error('Errore nella decodifica della classe');
    }

    is_course_name_ok() {
        if( this.state.course !== '' ) return true;
        if( this.state.course_type_label === 'SG' ) return true;
        return false;
    }

    render () {
        return (
            <Fragment>
            <Stack alignItems="center" spacing={2} width="100%">
                <SelectWithButtons
                    name="class"
                    options={ this.context.classes }
                    label_key="name"
                    value_key="_id"
                    value={ this.state.class }
                    onChange={ (e) => this.setState({ class: e.currentTarget.value }) }
                    />
                <SelectWithButtons
                    name="course_type"
                    options={ this.context.types }
                    label_key="name"
                    value_key="acronym"
                    value={ this.state.course_type_label }
                    onChange={ (e) => this.setState({ course_type_label: e.currentTarget.value, course: '' }) }
                    disabled={ this.state.class === '' }
                    />
                <ControlledDropdown
                    name="course"
                    value={ this.state.course }
                    options={ this.state.courses }
                    label_key="title"
                    value_key="title"
                    control_key="course_type"
                    control_field={ this.state.course_type_label }
                    extra_disabled={ this.state.course_type_label === 'SG' }
                    onChange={ (e) => this.setState({ course: e.target.value }) }
                    label="Corso di laurea"
                    />
                <CustomTextField
                    name="author"
                    disabled={ !this.is_course_name_ok() }
                    value={ this.state.author }
                    onChange={ (e) => this.setState({ author: e.target.value }) }
                    label="Laureato"
                    />
                <CustomTextField
                    name="advisor"
                    disabled={ !this.is_course_name_ok() }
                    value={ this.state.advisor }
                    onChange={ (e) => this.setState({ advisor: e.target.value }) }
                    label="Relatore/i"
                    />
                <FileUploader
                    name="thesis"
                    disabled={ !this.is_course_name_ok() || this.state.author === '' || this.state.advisor === '' }
                    onChange={ (e) => this.uploadForm( e.target.files[0] ) }
                    />
            </Stack>
            <MyBackDrop open={ this.state.loading } />
            </Fragment>
        )
    }

}

AddThesis.contextType = GlobalContext;

export default withSnackbar(AddThesis);