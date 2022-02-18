module.exports = {
    mode: 'jit',
    content: [
        './index.php',
        './home.php',
        './category.php',
        './templates/*',
        './parts/*',
        './src/*',
        './src/*'
    ],
    theme: require( './theme')
};
