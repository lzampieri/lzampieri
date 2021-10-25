import { TextField } from '@mui/material';
import { Component } from "react";


class CustomTextField extends Component {

    render() {
        return (
            <TextField
                sx={{
                    width: "100%",
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
                {...this.props} /* Contains name, label, value, onChange, disabled */
                />
        )
    }
};

export default CustomTextField;