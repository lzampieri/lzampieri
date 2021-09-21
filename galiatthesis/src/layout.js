import { Container } from "@mui/material";
import { Box } from "@mui/system";

function Layout({children}) {
    return (
        <Container>
            <Box
                display="flex"
                justifyContent="center"
                width="100%"
                p={3}
                >
                <Box
                    sx={ {
                        width: { xs: 1, sm: 0.6, md: 0.4 }
                    } }>
                    <img src="graphics/logo_color3.svg" alt="gali@thesis" width="100%" />
                </Box>
            </Box>
            <Box
                display="flex"
                justifyContent="center"
                width="100%"
                >
                Barra di navigazione
            </Box>
            { children }
        </Container>
    )
}

export default Layout;