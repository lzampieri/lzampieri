<?php get_template_part('parts/header'); ?>

<?php get_template_part('parts/normal_header'); ?>

<?php get_template_part('parts/navigation'); ?>

<?php get_template_part('parts/title', null, array( 'title' => single_post_title( "", false ) ) ); ?>

<?php get_template_part('parts/sections_list', null, array( 'sections_ref' => 'post_' . $wp_query->get_queried_object_id() ) ); ?>

<?php get_template_part('parts/content', null, array( 'content' => get_the_content() ) ); ?>

<?php get_template_part('parts/navigation_bottom'); ?>

<?php get_template_part('parts/footer'); ?>
