import { Component, Fragment } from "react";
import $ from 'jquery';
import { Form, Formik, Field } from 'formik';
import { Select } from 'formik-material-ui';
import GlobalContext from '../globalContext';
import { Box, MenuItem } from "@mui/material";
import SelectWithButtons from "../formComponents/selectWithButtons";

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

    validator(values) {
        return {};
    }

    async save(values) {
    }

    render () {
        return (
            <Fragment>
                <Formik
                    initialValues = { {
                        points: 1,
                        accessible_at: 0,
                        text: "",
                        class: "SM",
                        type: "LT",
                        id: -1
                    } }
                    validate = { values => this.validator(values) }
                    onSubmit = { values => this.save(values) }
                    enableReinitialize = {true}
                >
                    { ({submitForm, isSubmitting, errors}) => (
                    <Form style={{ width: "100%" }} p={2}>
                        <Box display="flex" flexDirection="column" alignItems="center" gap={2} width="100%">
                            <Field
                                component={SelectWithButtons}
                                name="class"
                                options={ this.context.classes }
                                label_key="name"
                                value_key="acronym"
                                >
                            </Field>
                            <Field
                                component={SelectWithButtons}
                                name="type"
                                options={ this.context.types }
                                label_key="name"
                                value_key="acronym"
                                >
                            </Field>
                            <Field
                                component={Select}
                                name="course"
                                style={{ width: "100%" }}
                                label="Corso">
                                { this.state.courses.map( c => 
                                    <MenuItem value={ c.title } key={ c.title }>{ c.title }</MenuItem>
                                )}
                            </Field>
                            {/* <Field
                                component={TextField}
                                name="id"
                                type="hidden"
                            />
                            <Field
                                component={TextField}
                                name="points"
                                type="number"
                                label="Punti"
                                style={{ width: "100%"}}
                                InputLabelProps={{ shrink: true }}
                            />
                            <Field
                                component={TextField}
                                name="accessible_at"
                                type="number"
                                label="Disponibile a:"
                                style={{ width: "100%" }}
                                InputLabelProps={{ shrink: true }}
                            />
                            <Field
                                component={TextField}
                                name="text"
                                InputProps={{
                                    multiline: true,
                                    rows: 10
                                }}
                                label="Enigma"
                                placeholder="Disponibili le espressioni #titoletto#, [img filename], [audio filename], [file displayname|filename], [link displayname|url]"
                                style={{ width: "100%" }}
                                InputLabelProps={{ shrink: true }}
                            />
                            <Button
                                variant="contained"
                                color="primary"
                                disabled={isSubmitting}
                                onClick={submitForm}
                                style={{ width: "100%" }}
                            >{this.props.enigmaId == -1 ? 'Crea' : 'Salva'} </Button>
                            <Backdrop open={isSubmitting} style={{ zIndex: 1500 }}>
                                <CircularProgress color="inherit" />
                            </Backdrop> */}
                        </Box>
                    </Form>
                    )}
                </Formik>
            </Fragment>
        )
    }
}

AddThesis.contextType = GlobalContext;

export default AddThesis;