import { Inertia } from '@inertiajs/inertia';
import { Button, Chip, Dialog, DialogActions, DialogContent, DialogContentText, DialogTitle } from '@mui/material';
import { withSnackbar } from 'notistack';
import { Component } from 'react'

class ClickableChip extends Component {
    constructor(props) {
        super(props);
        this.state = {
            dialog_open: false
        }
    }

    openDialog() {
        this.setState({ dialog_open: true });
    }

    dismissDialog() {
        this.setState({ dialog_open: false });
    }

    savePerm() {
        this.setState({ dialog_open: false });
        Inertia.post( public_url + this.props.postUrl,
            this.props.postData,
            {
                onError: ( errors ) =>
                    Object.entries( errors ).map( ([ key, value ]) => 
                        this.props.enqueueSnackbar( key + ": " + value, {variant: 'error'})
                    ),
                onSuccess: () =>
                    this.props.enqueueSnackbar( "Fatto", {variant: 'success'})
            }
        );
    }

    render() {
        return (
            <>
                <Chip {...this.props.chipProps} onClick={ () => this.openDialog() } />
                <Dialog
                    open={ this.state.dialog_open }
                    onClose={ () => this.dismissDialog() }
                >
                    <DialogTitle>{ this.props.dialogTitle }</DialogTitle>
                    <DialogContent>
                        <DialogContentText>
                            { this.props.dialogText }
                        </DialogContentText>
                    </DialogContent>
                    <DialogActions>
                        <Button onClick={ () => this.dismissDialog() }>Annulla</Button>
                        <Button onClick={ () => this.savePerm() }>
                            { this.props.confirmButtonText }
                        </Button>
                    </DialogActions>
                </Dialog>
            </>
        )
    }
}

export default withSnackbar( ClickableChip );