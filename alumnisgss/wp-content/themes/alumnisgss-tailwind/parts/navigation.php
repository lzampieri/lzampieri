<?php
    $themenu = wp_get_nav_menu_items( get_nav_menu_locations()[ current_user_can( 'read_private_posts' ) ? 'main-menu-private' : 'main-menu'] );
    $thereare = [];
    foreach( $themenu as $item ) {
        $thereare[ $item->menu_item_parent ] = true;
    }
    unset( $thereare[ 0 ] );
    if( $themenu ) {
        ?>
        <div
            x-data="{ <?php foreach( $themenu as $item ) { echo 'open_' . $item->ID . ': false, hover_' . $item->ID . ': false, '; } ?> }"
        >
        <span class="block md:hidden"> <!-- Mobile version -->
            <ul class="bg-light center flex flex-col justify-center items-center gap-2">
            <?php foreach( $themenu as $item ) { if( $item->menu_item_parent == 0 ) { ?>
                <a href="<?php echo $item->url; ?>"
                    class="w-full
                        shadow-background hover:shadow-2xl
                        text-base text-dark text-center"
                    :class="hover_<?php echo $item->ID; ?> ? 'shadow-2xl' : 'shadow-md'"
                    @mouseover="open_<?php echo $item->ID; ?> = true"
                    @mouseover.away="open_<?php echo $item->ID; ?> = false"
                    >
                    <?php echo apply_filters( 'the_title', $item->title ); ?>
                </a>
                <ul
                    class="bg-light center flex flex-col justify-center gap-2"
                    x-show="open_<?php echo $item->ID; ?> | hover_<?php echo $item->ID; ?>"
                    
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"

                    @mouseover="hover_<?php echo $item->ID; ?> = true"
                    @mouseover.away="hover_<?php echo $item->ID; ?> = false" >
                    <?php foreach( $themenu as $subitem ) { if( $subitem->menu_item_parent == $item->ID ) { ?>
                        <a href="<?php echo $subitem->url; ?>"
                            class="
                                shadow-background shadow-md hover:shadow-2xl
                                text-base text-dark text-center px-2"
                            >
                            <?php echo apply_filters( 'the_title', $subitem->title ); ?>
                        </a>
                    <?php }} ?>
                </ul>
            <?php }} ?>
            </ul>
        </span>
        <span class="hidden md:block"> <!-- Large screen version -->
            <ul class="bg-light center flex flex-row justify-center gap-2">
            <?php foreach( $themenu as $item ) { if( $item->menu_item_parent == 0 ) { ?>
                <a href="<?php echo $item->url; ?>"
                    class="h-28 w-28  
                        shadow-background hover:shadow-2xl
                        text-lg text-dark text-center
                        flex flex-col justify-center
                        group"
                    :class="hover_<?php echo $item->ID; ?> ? 'shadow-2xl' : 'shadow-md'"
                    @mouseover="open_<?php echo $item->ID; ?> = true"
                    @mouseover.away="open_<?php echo $item->ID; ?> = false"
                    >
                    <img class="h-12" src="<?php echo get_template_directory_uri(); ?>/assets/logo_background.svg" />
                    <span><?php echo apply_filters( 'the_title', $item->title ); ?></span>
                </a>
            <?php }} ?>
            </ul>
            <?php foreach( $themenu as $item ) { if( array_key_exists( $item->ID, $thereare ) ) { ?>
                <ul
                    class="bg-light center flex flex-row justify-center gap-2 pt-2"
                    x-show="open_<?php echo $item->ID; ?> | hover_<?php echo $item->ID; ?>"
                    
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"

                    @mouseover="hover_<?php echo $item->ID; ?> = true"
                    @mouseover.away="hover_<?php echo $item->ID; ?> = false" >
                <?php foreach( $themenu as $subitem ) { if( $subitem->menu_item_parent == $item->ID ) { ?>
                    <a href="<?php echo $subitem->url; ?>"
                        class="h-28 w-28  
                            shadow-md shadow-background hover:shadow-2xl
                            text-lg text-dark text-center
                            flex flex-col justify-center
                            group"
                        >
                        <img class="h-12" src="<?php echo get_template_directory_uri(); ?>/assets/logo_background.svg" />
                        <span><?php echo apply_filters( 'the_title', $subitem->title ); ?></span>
                    </a>
                <?php }} ?>
                </ul>
            <?php }} ?>
        </span>
        </div>
    <?php }
?>