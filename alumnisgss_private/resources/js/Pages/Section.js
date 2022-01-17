import Layout from "@/Layout";
import React from "react";
import MarkdownParser from "@/Components/MarkdownParser";
import { Box } from "@mui/system";
import { Button, Typography } from "@mui/material";
import { Link, usePage } from "@inertiajs/inertia-react";
import SectionChip from "@/Components/SectionChip";
import { Edit } from "@mui/icons-material";


export default function Section( {section} ) {
    const { auth } = usePage().props;
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
                        Modifica
                    </Button> }
                <Typography variant="h4">{ section.title }</Typography>
                <MarkdownParser>
                    { section.content }
                </MarkdownParser>
            </Box>
        </Layout>
    )
}