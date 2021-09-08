import { Box, Button, Card, CardContent, Typography, withStyles } from "@material-ui/core";

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
        <Box p={3} className={ props.classes.resizable_box }><Card>
            <CardContent>
                <Typography variant="h4" color="secondary">
                    { props.project.title }
                </Typography>
                { props.project.description }
                <Box display="flex" justifyContent="flex-end" width="100%">
                    <Button
                        variant="outlined"
                        color="primary"
                        href={ props.project.url }>
                        Vai al sito
                    </Button>
                </Box>
            </CardContent>
        </Card></Box>
    )
}

export default withStyles(style)(ProjectCard);