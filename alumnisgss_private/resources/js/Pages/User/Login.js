import { Field } from "@/Components/FormComponents";
import Layout from "@/Layout";
import { useForm } from "@inertiajs/inertia-react";
import { Button, Stack, Typography } from "@mui/material";

export default function Login() {
    const form = useForm({
        email: '',
        password: ''
    }); // Contains data, setData, post, processing, errors

    return (
        <Layout>
        <form onSubmit={ e => { e.preventDefault(); form.post('login') } }>
            <Stack alignItems='center' spacing={2} >
                <Typography variant='h5'>Login</Typography>
                <Field form={ form } name='email' label='Email' />
                <Field form={ form } name='password' label='Password' password />
                <Button
                    variant='outlined'
                    type='submit'
                    disabled={ form.processing }
                    >Login</Button>
            </Stack>
        </form>
        </Layout>
    )
}