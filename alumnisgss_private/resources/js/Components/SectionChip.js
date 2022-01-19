import { DeleteOutline, Security } from "@mui/icons-material";
import { Alert } from "@mui/material";

const { default: ClickableChip } = require("./ClickableChip")

export default function SectionChip( {section} ) {
    var reserved = ( section.reserved == 1 );
    var trashed = section.trashed;
    return (
    <>
        <ClickableChip
            chipProps = {{
                variant: reserved ? "filled" : "outlined",
                color: reserved ? "error" : "success",
                label: reserved ? "Sezione riservata" : "Sezione pubblica"
                }}
            dialogTitle = { reserved ? "Rendere la sezione pubblica?" : "Rendere la sezione riservata?"}
            dialogText = { reserved ? "Tutti gli utenti registrati e approvati potranno vederla" : "Solo gli utenti con permesso di accesso alle sezioni riservate potranno vederla." }
            confirmButtonText = { "Varia" }
            postUrl = { "/s/" + section.shortname + "/reserved" }
            postData = {{
                reserved: !reserved
                }}
            key={ "res_" + section.shortname } />
        <ClickableChip
            chipProps = {{
                variant: trashed ? "filled" : "outlined",
                color: trashed ? "error" : "success",
                label: trashed ? "Sezione eliminata" : "Sezione attiva"
                }}
            dialogTitle = { trashed ? "Ripristinare la sezione?" : "Eliminare la sezione?"}
            dialogText = { trashed ? "Sarà visibile agli utenti abilitati." : "Solo gli amministratori potranno vederla e recuperarla." }
            confirmButtonText = { trashed ? "Ripristina" : "Elimina" }
            postUrl = { "/s/" + section.shortname + "/trashed" }
            postData = {{
                trashed: !trashed
                }}
            key={ "tra_" + section.shortname } />
        { section.reserved == 1 && <Alert variant="outlined" severity="info" icon={<Security />} sx={{ my: 2 }}>
                    Questa è una sezione riservata, visibile solo agli utenti specificatamente abilitati.
                </Alert> }
        { section.trashed && <Alert variant="outlined" severity="error" icon={<DeleteOutline />} sx={{ my: 2 }}>
            Questa è una sezione eliminata, visibile solo agli amministratori.
        </Alert> }
    </>);
}