import { ThemeProvider } from "@emotion/react";
import { Box, CssBaseline, Grid } from "@mui/material";
import Image from "mui-image";
import React from "react";
import SectionsMenu from "./Components/SectionsMenu";
import theme from "./theme";


export default function Layout({ children }) {
    return (
        <>
            <CssBaseline />
            <ThemeProvider theme={ theme }>
                <Box sx={{
                    display: 'flex', flexDirection: 'column', alignItems: 'center',
                    mx: "auto",
                    p: 3,
                    width: { sx: 1, md: 0.75 }
                    }}>
                    <Box sx={{ width: { sx: 1, md: 0.66 } }}>
                        <Image src={ assets_url + "/logotitolo_grigio.png"} />
                    </Box>
                    <Grid container spacing={2}>
                        <Grid item xs={12} md={3}>
                            <SectionsMenu />
                        </Grid>
                        <Grid item xs={12} md={9}>
                            { children }
                        </Grid>
                    </Grid>
                </Box>
            </ThemeProvider>
        </>
    )
}