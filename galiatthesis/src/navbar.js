import { Component, Fragment } from "react";
import { Button, ButtonGroup, Drawer, IconButton, List, ListItem, useMediaQuery, useTheme } from "@mui/material";
import { Menu as MenuIcon } from '@mui/icons-material';
import { Link } from "react-router-dom";


const items = [
    { name: 'Lista', url: '/'},
    { name: 'Aggiungi', url: '/add'},
    { name: 'About', url: '/about'}
]

class NavbarClass extends Component {

    constructor(props) {
        super(props);
        this.state = {
            draweropen: false
        }
    }

    buttonMenu() {
        return (
            <ButtonGroup
                color='primary'>
                { items.map( i =>
                    <Button key={i.name}
                        component={Link} to={i.url}>
                        {i.name}
                    </Button> )
                }
            </ButtonGroup>
        )
    }

    hamburgerMenu() {
        return (
            <Fragment>
                <IconButton onClick={ () => this.setState({ draweropen: true }) } >
                    <MenuIcon />
                </IconButton>
                <Drawer anchor='bottom' open={ this.state.draweropen }
                    onClose={ () => this.setState({ draweropen: false }) }>
                    <List>
                        { items.map( i =>
                            <ListItem key={i.name}
                                component={Link} to={i.url}
                                sx={{ color: 'text.primary' }}
                                onClick={ () => this.setState({ draweropen: false }) }>
                                {i.name}
                            </ListItem> )
                        }
                    </List>
                </Drawer>
            </Fragment>
        )
    }

    render() {
        return this.props.mobile ? this.buttonMenu() : this.hamburgerMenu();
    }
}

export default function Navbar() {
    const theme = useTheme();
    const mobile = useMediaQuery(theme.breakpoints.up('md'));
    return <NavbarClass mobile={mobile} />;
};