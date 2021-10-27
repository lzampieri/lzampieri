import { Component } from "react";
import GlobalContext from '../globalContext';
import { Virtuoso } from 'react-virtuoso';
import { Button } from '@mui/material';

class ThesisList extends Component {

    render() {
        return (
            <Virtuoso
                totalCount={ this.context.thesis.length }
                itemContent={ index => <Button sx={{ width: '100%', wordWrap: 'break-word' }}>{ JSON.stringify( this.context.thesis[index] ) }</Button> }
                style={{ height: '400px' }}
                />
        )
    }
}

ThesisList.contextType = GlobalContext;

export default ThesisList;

// export default function ThesisList() {
//     return (
//         <GlobalContext.Consumer>
//             { value => (
//                 <Fragment>
//                     {value.classes.map( i => (<Chip label={ i.acronym } sx={{ bgcolor: i.color + "60", color: 'secondary.contrastText' }} />) ) }
//                     {value.types.map( i => (<Chip label={ i.acronym } color='primary' />) ) }
//                 </Fragment> 
//             ) }
//         </GlobalContext.Consumer>
//     )
// }