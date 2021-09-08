import { Button, ButtonGroup } from "@material-ui/core";
import { withStyles } from "@material-ui/styles";
import { Link } from "react-router-dom";

const items = [
    { name: 'Home', url: '/'},
    { name: 'Progetti', url: '/projects'},
    { name: 'Contatti', url: '/contacts'}
]

const style = (theme) => { return {
    navbar_button : {
        color: theme.palette.primary.main,
        "&:hover": {
            color: theme.palette.text.primary,
            backgroundColor: theme.palette.primary.main
        },
    }    
} }

function Navbar(props) {
    return (
        <ButtonGroup
            color='primary'>
            { items.map( i =>
                <Button key={i.name}
                    component={Link} to={i.url}
                    className={props.classes.navbar_button}>
                    {i.name}
                </Button> ) }
        </ButtonGroup>
    )
}

export default withStyles(style)(Navbar);