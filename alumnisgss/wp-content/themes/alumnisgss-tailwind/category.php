<?php get_template_part('parts/header'); ?>

<?php get_template_part('parts/normal_header'); ?>

<?php get_template_part('parts/navigation'); ?>

<?php get_template_part('parts/title', null, array( 'title' => single_cat_title( "", false ) ) ); ?>

<?php get_template_part('parts/sections_list', null, array( 'sections_ref' => 'cat_' . $wp_query->get_queried_object_id() ) ); ?>

<?php get_template_part('parts/carousel', null, array( 'cat_id' => $wp_query->get_queried_object_id() ) ); ?>

<?php get_template_part('parts/footer'); ?>
