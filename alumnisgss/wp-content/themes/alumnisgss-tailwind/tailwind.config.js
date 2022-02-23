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
        './src/*'
    ],
    theme: require( './theme')
};
