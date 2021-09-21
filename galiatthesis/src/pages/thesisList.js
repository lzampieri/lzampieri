import { Chip } from "@mui/material";
import { Fragment } from "react";
import GlobalContext from "../globalContext";

export default function ThesisList() {
    return (
        <GlobalContext.Consumer>
            { value => (
                <Fragment>
                    {value.classes.map( i => (<Chip label={ i.acronym } sx={{ bgcolor: i.color + "60", color: 'secondary.contrastText' }} />) ) }
                    {value.types.map( i => (<Chip label={ i.acronym } color='primary' />) ) }
                </Fragment> 
            ) }
        </GlobalContext.Consumer>
    )
}