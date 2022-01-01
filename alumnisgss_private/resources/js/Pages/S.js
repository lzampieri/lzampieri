import Layout from "@/Layout";
import { Typography } from "@mui/material";
import React from "react";


export default function S( {section} ) {
    console.log( section );
    return (
        <Layout>
            <Typography variant='h5'>{ section.title }</Typography>
            { section.content }
        </Layout>
    )
}