import { ToggleButton, ToggleButtonGroup } from '@mui/material';
import { Component } from "react";


class SelectWithButtons extends Component {

    render() {
        return (
            <ToggleButtonGroup
                {...this.props.field} /* Contains name, value, onChange */
                sx={ {
                    '& .MuiToggleButtonGroup-grouped': {
                        bgcolor: 'background.paper',
                        color: 'text.primary',
                        border: 1,
                        borderColor: 'primary.main'
                    },
                    '& .MuiToggleButtonGroup-grouped.Mui-selected': {
                        bgcolor: 'primary.main',
                        color: 'primary.contrastText'
                    },
                    '& .MuiToggleButtonGroup-grouped:hover': {
                        bgcolor: 'primary.dark',
                        color: 'primary.contrastText'
                    },
                }}>
                { this.props.options.map( o => (
                    <ToggleButton
                        name={ this.props.field.name } // Used as backref from Formik
                        value={ o[this.props.value_key] }
                        key={ o[this.props.value_key] }>
                        { o[this.props.label_key] }
                    </ToggleButton>
                ))}
            </ToggleButtonGroup>
        )
    }
};

export default SelectWithButtons;