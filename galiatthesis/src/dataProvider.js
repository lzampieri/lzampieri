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
                thesis: [],
                reloadData: () => this.loadData(),
                loading: true
            }
        }
    }

    async componentDidMount() {
        this.loadData(true);
    }

    async loadData(first = false) {
        if( this.state.data.loading && !first ) return;
        this.setState({ loading: true });
        let classes = (await $.get( process.env.REACT_APP_API_URL + "collections/get/classes")).entries;
        let types = (await $.get( process.env.REACT_APP_API_URL + "collections/get/types")).entries;
        let thesis = (await $.get( process.env.REACT_APP_API_URL + "collections/get/thesis?populate=1")).entries;
        this.setState({ data: { classes: classes, types: types, thesis: thesis, reloadData: () => this.loadData(), loading: false } } );
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
