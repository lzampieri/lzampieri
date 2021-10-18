import { Container, Paper } from "@mui/material";
import { Box } from "@mui/system";
import Navbar from "./navbar";

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
                <Navbar />
            </Box>
            <Box
                display="flex"
                justifyContent="center"
                width="100%"
                p={3}
                >
                <Paper
                    sx={ {
                        width: { xs: 1, md: 0.5 },
                        p: 3
                    } }>
                    { children }
                </Paper>
            </Box>
        </Container>
    )
}

export default Layout;