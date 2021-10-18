import { Component } from "react";
import GlobalContext from "./globalContext";
import $ from 'jquery';


class DataProvider extends Component {

    constructor(props) {
        super(props);
        this.state = {
            data: {
                classes: [],
                types: [],
                loading: true
            }
        }
    }

    async componentDidMount() {
        let classes = (await $.get( process.env.REACT_APP_API_URL + "collections/get/classes")).entries;
        let types = (await $.get( process.env.REACT_APP_API_URL + "collections/get/types")).entries;
        this.setState({ data: { classes: classes, types: types, loading: false } } );
    }

    render() {
        return (
            <GlobalContext.Provider value={ this.state.data }>
                { this.props.children }
            </GlobalContext.Provider>
        )
    }
}

export default DataProvider;
