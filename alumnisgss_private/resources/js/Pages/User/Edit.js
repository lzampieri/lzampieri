import { Field } from "@/Components/FormComponents";
import Layout from "@/Layout";
import { useForm, usePage } from "@inertiajs/inertia-react";
import { Alert, Badge, Button, Chip, Stack, Typography } from "@mui/material";

export default function Edit({ users, permissions }) {

    return (
        <Layout>
            <Alert sx={{ border:1, m: 2}} severity="info">Qui il sistema di gestione degli utenti.</Alert>
            <Alert sx={{ border:1, m: 2}} severity="info">Permessi disponibili: 
                { permissions.map( p => <Chip label={p.name} /> )}
            </Alert>
            { JSON.stringify( users ) }
        </Layout>
    )
}