import { Button, Input } from '@mui/material';
import { Component } from "react";


class FileUploader extends Component {

    render() {
        return (
            <label htmlFor={ this.props.name + '-id' }>
                <Input 
                    id={ this.props.name + '-id' }
                    type="file" 
                    sx={{ display: 'none' }}
                    {...this.props} // name, value, onChange
                    />
                <Button
                    variant="outlined"
                    component="span"
                    disabled={ this.props.disabled }>
                    Carica tesi
                </Button>
            </label>
        )
    }
};

export default FileUploader;