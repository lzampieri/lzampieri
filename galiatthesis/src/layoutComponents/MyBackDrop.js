import { Backdrop, CircularProgress } from '@mui/material';
import { Box } from '@mui/system';
import React from 'react';

class MyBackDrop extends React.Component {
    render() {
        return(
            <Backdrop style={{ zIndex: 1500 }} {...this.props} >
                <Box display="flex" flexDirection="column" justify="center" alignItems="center">
                    <CircularProgress />
                </Box>
            </Backdrop>
        )
    }
}

export default MyBackDrop;
