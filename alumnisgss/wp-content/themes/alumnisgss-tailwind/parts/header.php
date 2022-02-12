<!DOCTYPE html>

<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >
		<?php wp_head(); ?>
	</head>
	<body
	class="bg-background bg-no-repeat bg-contain bg-fixed"
    style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/homepage_background.svg')">