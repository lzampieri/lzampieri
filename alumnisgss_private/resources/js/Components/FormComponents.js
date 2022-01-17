import { TextField } from "@mui/material";


export function Field({ form, name, label, password, multiline }) {
    let other = {};
    if( password ) other.type = 'password';
    if( multiline ) other.multiline = true;
    return (
        <TextField
            id={ name }
            name={ name }
            autoComplete={ name }
            label={ label }
            value={ form.data[name] }
            onChange={ e => form.setData(e.target.name, e.target.value) }
            error={ form.errors[name] ? true : false }
            helperText={ form.errors[name] ? form.errors[name] : '' }
            { ...other }
            />
    )
}