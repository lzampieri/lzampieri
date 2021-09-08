import { Box, Container } from "@material-ui/core";
import Navbar from "../components/navbar";


function Layout({pre_menu, children}) {
    return (
        <Container>
            { pre_menu && (
                <Box
                    display="flex"
                    justifyContent="center"
                    width="100%"
                    p={3}
                    >
                    {pre_menu}
                </Box>
            ) }
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