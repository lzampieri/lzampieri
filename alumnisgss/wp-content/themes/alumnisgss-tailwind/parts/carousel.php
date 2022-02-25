<?php
    $posts = get_posts( array(
        'posts_per_page' => -1,
        'category' => $args['cat_id'],
        'post_status' => is_user_logged_in() ? array('publish', 'private') : array('publish')
    ));
    if( $posts ) {
        ?>
        <div class="flex flex-row items-center justify-center w-full pt-32">
            <ul class="flex flex-col md:flex-row flex-wrap justify-center gap-4 w-2/3">
            <?php foreach( $posts as $post ) { ?>
                <a href="<?php echo get_permalink( $post->ID ); ?>"
                    class="w-full md:w-1/4
                        shadow-contrast shadow-lg
                        bg-light text-background hover:bg-secondary hover:text-contrast
                        flex flex-row md:flex-col justify-center items-center
                        border-4 border-secondary
                        group
                        p-4"
                    >
                    <?php
                        $image = get_the_post_thumbnail_url( $post );
                        if( $image ) { ?>
                        <img class="w-1/3 md:w-full max-h-40 grayscale group-hover:grayscale-0" src="<?php echo $image; ?>" />
                    <?php } else { ?>
                        <img class="w-1/3 md:w-full max-h-40 block group-hover:hidden" src="<?php echo get_template_directory_uri(); ?>/assets/logo_background.svg" />
                        <img class="w-1/3 md:w-full max-h-40 hidden group-hover:block" src="<?php echo get_template_directory_uri(); ?>/assets/logo_contrast.svg" />
                    <?php } ?>
                    <h4 class="text-center px-4"><?php echo apply_filters( 'the_title', $post->post_title ); ?></h4>
                </a>
            <?php } ?>
            </ul>
        </div>
    <?php } ?>