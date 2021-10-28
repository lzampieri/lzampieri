import { Component } from "react";
import { Button, Chip, IconButton, ListItem, Stack, Typography } from '@mui/material';
import { Download } from '@mui/icons-material';

class ThesisListItem extends Component {

    render() {
        let th = this.props.thesis;
        return (
            <ListItem
                sx={{ width: '100%', border: 1, borderRadius: 4, borderColor: 'primary.main', my: 2 }}
                secondaryAction={ <IconButton color='primary' component='a' href={ process.env.REACT_APP_STORAGE_URL + th.file.path } ><Download/></IconButton> }>
            <Stack spacing={1}>
                <Stack direction='row'>
                    <Chip label={ th.class.acronym } sx={{ bgcolor: th.class.color + "60", color: 'secondary.contrastText'}} />
                    <Chip label={ th.course_type.acronym } color='primary' />
                    <Chip label={ th.course } color='secondary' />
                </Stack>
                <Typography variant='body1'>{ th.title }</Typography>
                <Typography variant='body2' color='text.disabled' >{ th.author } - { th.advisor }</Typography>
            </Stack>
            </ListItem>
        )
    }
}

export default ThesisListItem;

// export default function ThesisList() {
//     return (
//         <GlobalContext.Consumer>
//             { value => (
//                 <Fragment>
//                     {value.classes.map( i => (<Chip label={ i.acronym } sx={{ bgcolor: i.color + "60", color: 'secondary.contrastText' }} />) ) }
//                     {value.types.map( i => (<Chip label={ i.acronym } color='primary' />) ) }
//                 </Fragment> 
//             ) }
//         </GlobalContext.Consumer>
//     )
// }