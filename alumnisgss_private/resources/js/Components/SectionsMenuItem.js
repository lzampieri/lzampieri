import { Link } from "@inertiajs/inertia-react";
import { Button } from "@mui/material";


export default function SectionMenuItem({ title, url }) {
    return (
        <Button
            component={Link}
            href={ public_url + url }
            variant="outlined"
            sx={{
                justifyContent: 'left'
            }}>
            { title }
        </Button>
    )
}