import Layout from "@/Layout";
import React from "react";
import MarkdownParser from "@/Components/MarkdownParser";
import { Box } from "@mui/system";
import { Button, Typography } from "@mui/material";
import { Link, useForm, usePage } from "@inertiajs/inertia-react";
import SectionChip from "@/Components/SectionChip";
import { Edit } from "@mui/icons-material";

function FileUploader( {section} ) {
    const form = useForm({ thefile: "" });
    console.log( form.errors );
    return (
        <form onSubmit={ (e) => { e.preventDefault(); form.post( public_url + "/s/" + section.shortname + "/upload" ) } } >
            <input type="file" onChange={e => form.setData('thefile', e.target.files[0])} />
            <button type="submit">Submit</button>
        </form>
    )
}

export default function Section( {section} ) {
    const { auth } = usePage().props;
    console.log( section );
    var can_edit_section = Boolean( auth && auth.permissions.includes( "edit sections" ) );
    return (
        <Layout>
            <Box sx={{ p: 3, border: 1, borderRadius: 2 }}>
                { can_edit_section && <SectionChip section={ section } /> }
                { can_edit_section && <Button
                    component={Link}
                    href={ public_url + "/s/" + section.shortname + "/edit" }
                    color="info"
                    variant="outlined"
                    startIcon={ <Edit /> }>
                        Modifica testi
                    </Button> }
                <Typography variant="h4">{ section.title }</Typography>
                <MarkdownParser>
                    { section.content }
                </MarkdownParser>
                <FileUploader section={ section } />
            </Box>
        </Layout>
    )
}