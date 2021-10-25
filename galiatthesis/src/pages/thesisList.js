import { Component } from "react";
import GlobalContext from '../globalContext';

class ThesisList extends Component {

    constructor(props) {
        super(props);
    }

    render() {
        return JSON.stringify( this.context.thesis )
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