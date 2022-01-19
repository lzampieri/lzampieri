import { Field } from "@/Components/FormComponents";
import Layout from "@/Layout";
import { useForm, usePage } from "@inertiajs/inertia-react";
import { Alert, Button, Stack, Typography } from "@mui/material";

export default function Unverified() {
    const { auth } = usePage().props;

    return (
        <Layout>
            { auth.email_verified_at == null && <Alert sx={{ border:1, m: 2}} severity="warning">Il tuo indirizzo mail non è ancora stato verificato. Clicca sul link di verifica che ti è stato inviato al momento della registrazione.</Alert>}
            { auth.user_verified_at == null && <Alert sx={{ border:1, m: 2}} severity="warning">La tua identità non è ancora stata verificata. Devi attendere che la segreteria verifichi il tuo documento d'identità.</Alert>}
        </Layout>
    )
}