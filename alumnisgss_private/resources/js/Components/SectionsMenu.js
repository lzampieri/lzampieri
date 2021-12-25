import { usePage } from "@inertiajs/inertia-react"
import { Stack } from "@mui/material";
import React from "react"
import SectionMenuItem from "./SectionsMenuItem";


export default function SectionsMenu() {
    const { sections } = usePage().props;
    return (
        <Stack spacing={2}>
            <SectionMenuItem title="Home" url="/" /> 
            { sections.map( s => <SectionMenuItem title={ s.title } url={ "/s/" + s.shortname } /> ) }
            <SectionMenuItem title="Logout" url="/auth/logout" /> 
        </Stack>
    )
}