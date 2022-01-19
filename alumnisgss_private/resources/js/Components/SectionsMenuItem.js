import { Link } from "@inertiajs/inertia-react";
import { DeleteOutline, Security } from "@mui/icons-material";
import { Button } from "@mui/material";


export default function SectionMenuItem({ title, url, disabled, reserved, deleted_at }) {
    var extra_props = {};
    if( deleted_at ) extra_props.color = "error";
    return (
        <Button
            component={Link}
            href={ public_url + url }
            variant="outlined"
            sx={{
                justifyContent: 'left'
            }}
            { ...extra_props }
            disabled={ disabled } >
            { reserved == 1 && <Security fontSize="small"/> }
            { deleted_at && <DeleteOutline fontSize="small" /> }
            { title }
        </Button>
    )
}