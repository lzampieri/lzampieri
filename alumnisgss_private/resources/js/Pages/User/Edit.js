import Layout from "@/Layout";
import { Alert, Button, Chip, Dialog, DialogActions, DialogContent, DialogContentText, DialogTitle, List, ListItem, ListItemIcon, Paper, Stack, Typography } from "@mui/material";
import AccountCircle from '@mui/icons-material/AccountCircle';
import { Link, usePage } from "@inertiajs/inertia-react";
import { Component } from "react";
import { SnackbarProvider, withSnackbar } from 'notistack';
import { Inertia } from "@inertiajs/inertia";

function pD( date ) {
    return ( new Date( date )).toLocaleDateString("it-IT");
}

class PermissionChip extends Component {
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
        Inertia.post( public_url + '/u/edit/perms',
            { should_have: !this.props.hasIt, user: this.props.uid, perm: this.props.pname },
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
                { this.props.hasIt ? 
                    <Chip color="success" label={ this.props.pname } onClick={ () => this.openDialog() } /> :
                    <Chip variant="outlined" color="error" label={ this.props.pname } onClick={ () => this.openDialog() } />
                }
                <Dialog
                    open={ this.state.dialog_open }
                    onClose={ () => this.dismissDialog() }
                >
                    <DialogTitle>{ this.props.hasIt ? "Revocare " : "Assegnare "} il permesso?</DialogTitle>
                    <DialogContent>
                        <DialogContentText>
                            { this.props.hasIt ? "Revocare " : "Assegnare "} il permesso <i>{ this.props.pname }</i> all'utente { this.props.uname }?
                        </DialogContentText>
                    </DialogContent>
                    <DialogActions>
                        <Button onClick={ () => this.dismissDialog() }>Annulla</Button>
                        <Button onClick={ () => this.savePerm() }>
                            { this.props.hasIt ? "Revoca" : "Assegna" }
                        </Button>
                    </DialogActions>
                </Dialog>
            </>
        )
    }
}

const SnackbarPermissionChip = withSnackbar( PermissionChip );

function UserItem({ user, permissions, me }) {
    return (
        <ListItem component={Paper} variant="outlined" sx={{ my: 2 }}>
            <ListItemIcon><AccountCircle /></ListItemIcon>
            <Stack spacing={1}>
                <Typography variant="caption">Registrato il { pD(user.created_at) }</Typography>
                <Typography variant="h6">{ me && <Chip color="info" label="Tu" /> }<b> { user.name }</b> { user.email }</Typography>
                <Stack direction="row" spacing={1}>
                    { user.email_verified_at ?
                        <Chip color="success" label={ "Email verificata il " + pD(user.email_verified_at) } /> :
                        <Chip color="warning" label="Email non verificata" /> }
                    { user.user_verified_at ?
                        <Chip color="success" label={ "Identità verificata il " + pD(user.user_verified_at) } /> :
                        <Chip color="warning" label="Identità non verificata" /> }
                </Stack>
                <Stack direction="row" alignItems="center" spacing={1}>
                    <b>Permessi: </b>
                    { permissions.map( p =>
                        <SnackbarPermissionChip key={ p.name } pname={ p.name } uid={ user.id } uname={ user.name } hasIt={ user.permissions.includes(p.name) } />
                    )}
                </Stack>
            </Stack>
        </ListItem>
    )
}

export default function Edit({ users, permissions }) {
    const { auth } = usePage().props;
    return (
        <Layout>
        <SnackbarProvider>
            <List>{ users.map( u => <UserItem key={ u.id } user={u} permissions={permissions} me={ u.id == auth.id } /> ) }</List>
        </SnackbarProvider>
        </Layout>
    )
}