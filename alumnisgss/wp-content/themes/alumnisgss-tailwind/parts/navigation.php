<?php
    $themenu = wp_get_nav_menu_items( get_nav_menu_locations()['main-menu'] );
    if( $themenu ) {
        ?>
        <ul class="bg-light center flex flex-row justify-center gap-3">
        <?php foreach( $themenu as $item ) { ?>
            <a href="<?php echo $item->url; ?>"
                class="h-28 w-28 border-4 border-secondary rounded
                       text-lg text-background
                       flex flex-col justify-center
                       group hover:text-contrast hover:bg-secondary">
                <img class="h-12 group-hover:h-0" src="<?php echo get_template_directory_uri(); ?>/assets/logo_background.svg" />
                <img class="h-0 group-hover:h-12" src="<?php echo get_template_directory_uri(); ?>/assets/logo_contrast.svg" />
                <span class="text-center"><?php echo $item->title; ?></span>
            </a>
        <?php } ?>
        </ul>
    <?php }
?>