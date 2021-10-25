import { FormControl, InputLabel, MenuItem, Select } from '@mui/material';
import { Component } from "react";


class ControlledDropdown extends Component {

    render() {
        return (
            <FormControl fullWidth
                sx={{
                        '& .MuiOutlinedInput-root' : {
                            '& fieldset': {
                                borderColor: 'primary.main',
                            },
                            '&.Mui-disabled fieldset': {
                                borderColor: 'rgba(0, 0, 0, 0.12)',
                            },
                        },
                        '& label': {
                            color: 'primary.main',
                            '&.Mui-disabled ': {
                                color: 'rgba(0, 0, 0, 0.24)'
                            }
                        },
                    }}
            >
                <InputLabel
                    id={ this.props.name + "-label" }
                    disabled={ this.props.control_field === '' || this.props.extra_disabled }>
                    { this.props.label }
                </InputLabel>
                <Select
                    style={{ width: "100%" }}
                    labelId={ this.props.name + "-label" } 
                    disabled={ this.props.control_field === '' || this.props.extra_disabled }
                    displayEmpty
                    {...this.props} /* Contains name, label, value, onChange */
                    >

                    { this.props.options.map( o => (
                        o[ this.props.control_key ] === this.props.control_field &&
                        <MenuItem
                            value={ o[this.props.value_key] }
                            key={ o[this.props.value_key] }>
                            { o[this.props.label_key] }
                        </MenuItem>
                    ))}

                </Select>
            </FormControl>
        )
    }
};

export default ControlledDropdown;