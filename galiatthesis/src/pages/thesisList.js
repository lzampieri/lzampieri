import { Component } from "react";
import GlobalContext from '../globalContext';
import { Virtuoso } from 'react-virtuoso';
import ThesisListItem from "./thesisListItem";

class ThesisList extends Component {

    render() {
        return (
            <Virtuoso
                totalCount={ this.context.thesis.length }
                itemContent={ index => <ThesisListItem thesis={ this.context.thesis[ this.context.thesis.length - index - 1 ] } /> }
                style={{ height: '400px' }}
                />
        )
    }
}

ThesisList.contextType = GlobalContext;

export default ThesisList;