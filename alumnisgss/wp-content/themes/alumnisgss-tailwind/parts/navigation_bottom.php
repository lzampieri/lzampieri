<?php
$themenu = wp_get_nav_menu_items( get_nav_menu_locations()[ is_user_logged_in() ? 'footer-menu-private' : 'footer-menu' ] );
?>
<ul class="w-full bg-light grid grid-flow-row grid-cols-1 md:grid-cols-4 px-8 py-16 mt-32">
<?php foreach( $themenu as $item ) { if( $item->menu_item_parent == 0 ) { ?>
    <div>
        <a href="<?php echo $item->url; ?>">
            <h5><?php echo apply_filters( 'the_title', $item->title ); ?></h5>
        </a>
        <?php foreach( $themenu as $subitem ) { if( $subitem->menu_item_parent == $item->ID ) { ?>
            <a href="<?php echo $subitem->url; ?>">
                <?php echo apply_filters( 'the_title', $subitem->title ); ?>
            </a><br/>
        <?php }} ?>
    </div>
<?php }} ?>
</ul>
<ul class="w-full bg-light text-center px-8 pb-4">
    <?php echo get_option( "alumnisgss_footer_tagline" ); ?>
</ul>