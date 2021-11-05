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
                loading: true,
                token: 'c212b487ccb9bc2c3c3ca3ca3fe9ea'
            }
        }
    }

    async componentDidMount() {
        this.loadData(true);
    }

    async loadData(first = false) {
        if( this.state.data.loading && !first ) return;
        let new_data = {...this.state.data}; // Complete copy of data, to ensure is seen as different from subsequent comparings
        new_data.classes = (await $.get( process.env.REACT_APP_API_URL + "collections/get/classes?token=" + this.state.data.token)).entries;
        new_data.types = (await $.get( process.env.REACT_APP_API_URL + "collections/get/types?token=" + this.state.data.token)).entries;
        new_data.thesis = (await $.get( process.env.REACT_APP_API_URL + "collections/get/thesis?populate=1&token=" + this.state.data.token)).entries;
        new_data.loading = false;
        this.setState( { data: new_data } );
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
