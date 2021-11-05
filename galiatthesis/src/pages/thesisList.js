import { Component } from "react";
import GlobalContext from '../globalContext';
import { Virtuoso } from 'react-virtuoso';
import ThesisListCollapser from "./thesisListCollapser";
import { Chip, Stack, TextField } from "@mui/material";

class ThesisList extends Component {

    constructor(props) {
        super(props);
        this.state = {
            text_filter: '',
            chips_enabled: {}
        }
    }

    getChips(array) {
        return (
            <Stack direction='row'>
                { array.map( c => 
                    <Chip
                        label={ c.acronym }
                        sx={ this.getChipStyle( this.isEnabled( c._id ), c.color ) }
                        onClick={ () => this.switchChip(c._id) }
                        key={ c._id }
                    />
                )}
            </Stack>
        )
    }

    isEnabled( id ) {
        if( this.state.chips_enabled[id] === undefined ) return true;
        return this.state.chips_enabled[id];
    }

    switchChip( id ) {
        let new_dict = this.state.chips_enabled;
        new_dict[ id ] = !this.isEnabled(id);
        this.setState({ chips_enabled: new_dict });
    }

    getChipStyle( enabled, color ) {
        let color_enabled = color ? color + "60" : 'primary.main';
        let text_enabled  = color ? 'secondary.contrastText' : 'primary.contrastText';
        if( enabled )
            return { bgcolor: color_enabled, color: text_enabled, border: 1, borderColor: color_enabled};
        else return { bgcolor: "#00000000", color: 'text.primary', border: 1, borderColor: color_enabled};
    }

    isOpen( th ) {
        if( !this.isEnabled( th.class._id ) ) return false;
        if( !this.isEnabled( th.course_type._id ) ) return false;
        let check_string = th.course + th.title + th.author + th.advisor;
        check_string = check_string.toLowerCase();
        return check_string.includes( this.state.text_filter.toLowerCase() );
    }
    
    render() {
        return (
            <Stack alignItems='flex-end'>
            { this.getChips( this.context.classes) }
            { this.getChips( this.context.types  ) }
            <TextField
                sx={{ width: '50%' }}
                value={ this.state.text_filter }
                onChange={ (e) => this.setState({ text_filter: e.target.value })} 
                label="Cerca..."
                />
            <Virtuoso
                totalCount={ this.context.thesis.length }
                itemContent={ index => 
                    <ThesisListCollapser
                        thesis={ this.context.thesis[ this.context.thesis.length - index - 1 ] } 
                        open={ this.isOpen( 
                            this.context.thesis[ this.context.thesis.length - index - 1 ]
                        ) }
                        key={ index }
                    /> }
                style={{ height: '400px', width: '100%' }}
                />
            </Stack>
        )
    }
}

ThesisList.contextType = GlobalContext;

export default ThesisList;