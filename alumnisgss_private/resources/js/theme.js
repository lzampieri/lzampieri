import { createTheme } from '@mui/material/styles';

const theme = createTheme({
    "palette": {
        "background": {
            "default": "#FFFFFF",
            "paper": "#3E3E3E"
        },
        "text": {
            "default": "#000000",
            "paper": "#FFFFFF"
        },
        "primary": {
            "main": "#E1E1E1",
            "hover": "#FF0000"
        }
    }  
});

export default theme;
