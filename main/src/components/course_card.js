import { Box, Button, Card, CardContent, Collapse, List, ListItem, ListItemIcon, ListItemText, Typography, withStyles } from "@material-ui/core";
import { ExpandLess, ExpandMore } from '@material-ui/icons';
import { FilePdfBox, Presentation } from 'mdi-material-ui';
import React, { useState } from "react";
import { api_url } from "../config";

const style = (theme) => { return {
    resizable_box: {
        width: '60%',
        [theme.breakpoints.down('sm')]: {
            width: '100%',
        },
    }
}}

function format_icon(url) {
    const ext = url.match(/\..+$/);
    if( ext[0] === ".pdf" )
        return <FilePdfBox />
    if( ext[0] === ".ppt" )
        return <Presentation />
    if( ext[0] === ".pptx" )
        return <Presentation />
    return ext[0];
}

function list_item(a) {
    return (
    <ListItem
        button key={a._id}
        component='a'
        href={ api_url + '../../' + a.attachment }
        >
        <ListItemIcon>
            { format_icon(a.attachment) }
        </ListItemIcon>
        <ListItemText primary={a.title} />
    </ListItem>
    )
}

function CourseCard(props) {
    const [open, setOpen] = useState(false);

    return (
        <Box p={3} className={ props.classes.resizable_box }><Card raised={true}>
            <CardContent>
                <Typography variant="h4" color="secondary">
                    { props.course.title }
                </Typography>
                <Typography variant="overline" color="secondary" display="block">
                    { props.course.occasion }
                </Typography>
                <Typography variant="overline" color="secondary" display="block">
                    Target: { props.course.target }
                </Typography>
                { props.course.description }
                { props.course.attachments.length && (
                    <Box display="flex" justifyContent="center" width="100%" pt={2} >
                        <Button
                            variant="outlined"
                            color="secondary"
                            onClick={ () => setOpen( !open ) }>
                            { open ? 
                                <React.Fragment>
                                    <ExpandLess />
                                    <Box mx={2}>Materiale didattico</Box>
                                    <ExpandLess />
                                </React.Fragment>
                                :
                                <React.Fragment>
                                    <ExpandMore />
                                    <Box mx={2}>Materiale didattico</Box>
                                    <ExpandMore />
                                </React.Fragment>
                                }
                        </Button>
                    </Box>
                ) }
                <Collapse in={ open }>
                    <List>
                        { props.course.attachments.map( a => list_item(a)) }
                    </List>
                </Collapse>
            </CardContent>
        </Card></Box>
    )
}

export default withStyles(style)(CourseCard);