import { createTheme } from '@material-ui/core/styles';

const theme = createTheme({
    palette: {
        type: 'dark',
        primary: {
            main: '#e21a41',
        },
        secondary: {
            main: '#e0e0e0'
        }
    },
    shape: {
        borderRadius: 0,
      },     
});

export default theme;
