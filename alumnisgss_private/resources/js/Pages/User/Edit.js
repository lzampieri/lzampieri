import Layout from "@/Layout";
import { Chip, List, ListItem, ListItemIcon, Paper, Stack, Typography } from "@mui/material";
import AccountCircle from '@mui/icons-material/AccountCircle';
import { usePage } from "@inertiajs/inertia-react";
import ClickableChip from "@/Components/ClickableChip";

function pD( date ) {
    return ( new Date( date )).toLocaleDateString("it-IT");
}

function UserItem({ user, permissions, me }) {
    return (
        <ListItem component={Paper} variant="outlined" sx={{ my: 2 }}>
            <ListItemIcon><AccountCircle /></ListItemIcon>
            <Stack spacing={1}>
                <Typography variant="caption">Registrato il { pD(user.created_at) }</Typography>
                <Typography variant="h6">{ me && <Chip color="info" label="Tu" /> }<b> { user.name }</b> { user.email }</Typography>
                <Stack direction="row" spacing={1}>
                    <ClickableChip
                        chipProps = {{
                            color: user.email_verified_at ? "success" : "error",
                            label: user.email_verified_at ? "Email verificata il " + pD(user.email_verified_at) : "Email non verificata"
                            }}
                        dialogTitle = { user.email_verified_at ? "Revocare verifica?" : "Verificare indirizzo mail?" }
                        dialogText = { user.email_verified_at ?
                            <>Revocare la validazione dell'indirizzo mail dell'utente { user.name }?<br/>Verrà inviato all'utente un nuovo link di verifica.</> :
                            <>Validare l'indirizzo mail dell'utente { user.name }?<br/>Nota: questa operazione dovrebbe di norma venire fatta autonomamente dall'utente, tramite un link che riceve via mail.</>                        }
                        confirmButtonText = { user.email_verified_at ? "Revoca" : "Valida" }
                        postUrl = '/u/edit/email'
                        postData = {{
                            user: user.id,
                            valid: user.email_verified_at ? false : true
                            }}
                        key={ 'email_verification' } />
                    <ClickableChip
                        chipProps = {{
                            color: user.user_verified_at ? "success" : "error",
                            label: user.user_verified_at ? "Identità verificata il " + pD(user.user_verified_at) : "Identità non verificata"
                            }}
                        dialogTitle = { user.user_verified_at ? "Revocare verifica?" : "Verificare l'identità?" }
                        dialogText = { user.user_verified_at ?
                            <>Revocare la validazione dell'identità dell'utente { user.name }?</> :
                            <>Validare l'identità dell'utente { user.name }?<br/>Nota: questa operazione permetterà all'utente l'accesso al sito. Dovrebbe essere effettuata dopo aver acquisito un documento d'identità.</>
                            }
                        confirmButtonText = { user.user_verified_at ? "Revoca" : "Valida" }
                        postUrl = '/u/edit/identity'
                        postData = {{
                            user: user.id,
                            valid: user.user_verified_at ? false : true
                            }}
                        key={ 'identity_verification' } />
                </Stack>
                <Stack direction="row" alignItems="center" spacing={1}>
                    <b>Permessi: </b>
                    { permissions.map( p => {
                        let hasIt = user.permissions.includes(p.name);
                        return <ClickableChip
                            chipProps = {{
                                variant: hasIt ? "filled" : "outlined",
                                color: hasIt ? "success" : "error",
                                label: p.name
                                }}
                            dialogTitle = { hasIt ? "Revocare il permesso?" : "Assegnare il permesso?"}
                            dialogText = { <> {hasIt ? "Revocare " : "Assegnare "} il permesso <i>{p.name}</i> all'utente {user.name}?</> }
                            confirmButtonText = { hasIt ? "Revoca" : "Assegna" }
                            postUrl = '/u/edit/perms'
                            postData = {{
                                should_have: !hasIt,
                                user: user.id,
                                perm: p.name
                                }}
                            key={ p.name + "_" + user.email } />
                    })}
                </Stack>
            </Stack>
        </ListItem>
    )
}

export default function Edit({ users, permissions }) {
    const { auth } = usePage().props;
    return (
        <Layout>
            <List>{ users.map( u => <UserItem key={ u.id } user={u} permissions={permissions} me={ u.id == auth.id } /> ) }</List>
        </Layout>
    )
}