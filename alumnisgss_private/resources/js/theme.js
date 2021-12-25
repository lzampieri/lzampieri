import { createTheme } from '@mui/material/styles';

const theme = createTheme({
    "palette": {
        "background": {
            "default": "#FFFFFF"
        },
        "text": {
            "default": "#000000",
            "paper": "#FFFFFF"
        },
        "primary": {
            "main": "#3E3E3E",
            "hover": "#FF0000"
        },
        "secondary": {
            "main": "#E1E1E1",
        }
    }  
});

export default theme;
