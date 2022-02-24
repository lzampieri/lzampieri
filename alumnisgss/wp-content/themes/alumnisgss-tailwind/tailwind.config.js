module.exports = {
    mode: 'jit',
    content: [
        './index.php',
        './home.php',
        './category.php',
        './single.php',
        './page.php',
        './templates/*',
        './parts/*',
        './src/*',
        './src/*',
        './app.css' // To force compilation of all explicitly defined stuff
    ],
    theme: require( './theme')
};
