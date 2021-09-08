import { Box, Button, Card, CardContent, Typography } from "@material-ui/core";

function ProjectCard(props) {
    return (
        <Box width="33%" p={3}><Card>
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

export default ProjectCard;