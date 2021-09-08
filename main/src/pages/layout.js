import { Box, Container, Typography } from "@material-ui/core";
import Navbar from "../components/navbar";


function Layout({children}) {
    return (
        <Container>
            <Box
                display="flex"
                justifyContent="center"
                width="100%"
                p={3}
                >
                <Typography variant="h3" color='secondary'>lzampieri</Typography>
            </Box>
            <Box
                display="flex"
                justifyContent="center"
                width="100%"
                >
                <Navbar />
            </Box>
            { children }
        </Container>
    )
}

export default Layout;