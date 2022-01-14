import Layout from "@/Layout";
import React from "react";
import MarkdownParser from "@/Components/MarkdownParser";
import { Box } from "@mui/system";
import { Alert } from "@mui/material";
import { DeleteOutline, Security } from "@mui/icons-material";


export default function Section( {section} ) {
    return (
        <Layout>
            <Box sx={{ p: 3, border: 1, borderRadius: 2 }}>
                { section.reserved == 1 && <Alert variant="outlined" severity="info" icon={<Security />}>
                    Questa è una sezione riservata, visibile solo agli utenti specificatamente abilitati.
                </Alert> }
                { section.trashed && <Alert variant="outlined" severity="error" icon={<DeleteOutline />}>
                    Questa è una sezione eliminata, visibile solo agli amministratori.
                </Alert> }
                <MarkdownParser>
                    #{ section.title } {'\n'}
                    { section.content }
                </MarkdownParser>
            </Box>
        </Layout>
    )
}