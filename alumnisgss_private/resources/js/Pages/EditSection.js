import Layout from "@/Layout";
import React from "react";
import MarkdownParser from "@/Components/MarkdownParser";
import { Box } from "@mui/system";
import { Button, Chip, Stack, Typography } from "@mui/material";
import { useForm, usePage } from "@inertiajs/inertia-react";
import SectionChip from "@/Components/SectionChip";
import { Field } from "@/Components/FormComponents";
import { Save } from "@mui/icons-material";

export default function EditSection( {section} ) {
    const { auth } = usePage().props;
    const form = useForm({
        title: section.title,
        content: section.content
      });
      
    return (
        <Layout>
            <Box sx={{ p: 3, border: 1, borderRadius: 2 }}>
                <Stack component="form" onSubmit={ (e) => { e.preventDefault(); form.post('edit') } }
                    alignItems="stretch" spacing={2} >
                    <Button
                        type="submit"
                        color="info"
                        variant="outlined"
                        startIcon={ <Save /> }>
                        Salva
                    </Button>
                    <Field form={ form } name='title' label='Titolo' />
                    <Field form={ form } name='content' label='Contenuto' multiline />
                    <Box sx={{ whiteSpace: 'pre-line' }}>{`
                        Alcune indicazioni per scrivere:
                        *Testo corsivo*
                        **Testo in grassetto**
                        ***Testo in corsivo e grassetto***
                        ~~Testo barrato~~
                        # Titolo
                        ## Sottotitolo
                        ### Titoletto
                        - Elenco puntato
                        1. Elenco numerato
                        [Testo del link](url a cui puntare)
                        ![](url di una immagine)
                        `}</Box>
                </Stack>
            </Box>
        </Layout>
    );
}