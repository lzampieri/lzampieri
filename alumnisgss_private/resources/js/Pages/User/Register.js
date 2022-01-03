import { Field } from "@/Components/FormComponents";
import Layout from "@/Layout";
import { useForm } from "@inertiajs/inertia-react";
import { Button, Stack, Typography } from "@mui/material";

export default function Register() {
    const form = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
    }); // Contains data, setData, post, processing, errors

    return (
        <Layout>
        <form onSubmit={ e => { e.preventDefault(); form.post('register') } }>
            <Stack alignItems='center' spacing={2} >
                <Typography variant='h5'>Registrazione</Typography>
                <Field form={ form } name='name' label='Nome' />
                <Field form={ form } name='email' label='Email' />
                <Field form={ form } name='password' label='Password' password />
                <Field form={ form } name='password_confirmation' label='Ripeti password' password />
                <Button
                    variant='outlined'
                    type='submit'
                    disabled={ form.processing }
                    >Registrati</Button>
            </Stack>
        </form>
        </Layout>
    )
}