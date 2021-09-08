import { Box, Button, Card, CardContent, IconButton, Typography, withStyles } from "@material-ui/core";
import GitHubIcon from '@material-ui/icons/GitHub';
import { api_url } from "../config";

const style = (theme) => { return {
    resizable_box: {
        width: '33%',
        [theme.breakpoints.down('sm')]: {
            width: '100%',
        },
    }
}}

function ProjectCard(props) {
    return (
        <Box p={3} className={ props.classes.resizable_box }><Card raised={true}>
            <CardContent>
                <Typography variant="h4" color="secondary">
                    { props.project.title }
                </Typography>
                { props.project.image &&
                    <Box display="flex" justifyContent="center" width="100%" py={2} >
                        <img src={ api_url + '../../' + props.project.image.path } alt={ props.project.title } style={{ maxWidth:"100%", maxHeight: 150}}  />
                    </Box>
                }
                { props.project.description }
                <Box display="flex" justifyContent="space-between" flexDirection="row-reverse" width="100%" pt={2} >
                    <Button
                        variant="outlined"
                        color="primary"
                        href={ props.project.url }>
                        Vai al sito
                    </Button>
                    { props.project.github && 
                        <Button
                            variant="outlined"
                            color="secondary"
                            href={ props.project.github }>
                            <GitHubIcon aria-label="Github" />
                        </Button>
                    }
                </Box>
            </CardContent>
        </Card></Box>
    )
}

export default withStyles(style)(ProjectCard);