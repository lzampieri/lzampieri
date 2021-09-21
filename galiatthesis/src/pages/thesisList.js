import { Chip } from "@mui/material";
import GlobalContext from "../globalContext";

export default function ThesisList() {
    return (
        <GlobalContext.Consumer>
            { value => value.classes.map( i => (
                <Chip label={ i.acronym } sx={{ bgcolor: i.color + "60", color: 'secondary.contrastText' }} />
            )) }
        </GlobalContext.Consumer>
    )
}