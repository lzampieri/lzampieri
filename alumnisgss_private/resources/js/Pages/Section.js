import Layout from "@/Layout";
import React from "react";
import MarkdownParser from "@/Components/MarkdownParser";
import { Box } from "@mui/system";


export default function Section( {section} ) {
    return (
        <Layout>
            <Box sx={{ p: 3, border: 1, borderRadius: 2 }}>
                <MarkdownParser>
                    #{ section.title } {'\n'}
                    { section.content }
                </MarkdownParser>
            </Box>
        </Layout>
    )
}