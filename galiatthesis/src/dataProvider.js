import { Component } from "react";
import { api_url } from "./config";
import GlobalContext from "./globalContext";
import $ from 'jquery';


class DataProvider extends Component {

    constructor(props) {
        super(props);
        this.state = {
            data: {
                classes: [],
                loading: true
            }
        }
    }

    async componentDidMount() {
        let classes = (await $.get( api_url + "collections/get/classes")).entries;
        let types = (await $.get( api_url + "collections/get/types")).entries;
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
