<?php

    $sections = get_posts( array (
        'numberposts' => -1,
        'post_type' => 'alumnisgss_sections',
        'order' => 'ASC',
        'orderby'    => 'ID',
        'meta_query' => array(
                array(
                    'key'   => 'item_to_refer',
                    'value' => $args['sections_ref'],
                )
            )
    ));
    
    $count = 0;
    foreach( $sections as $section ) {
        $count++;
        $image = get_the_post_thumbnail_url( $section );
        if( $image ) {
    ?>
        <div class="flex flex-col items-center justify-center px-16 pt-64 first:pt-32">
            <div class="flex <?php echo ( $count % 2 == 0 ? "flex-row" : "flex-row-reverse" ); ?> w-full items-center">
                <span class="text-contrast grow basis-0">
                    <h4><?php echo $section->post_title; ?></h4>
                    <?php echo $section->post_content; ?>
                </span>
                <span class="separator"></span>
                <span
                    class="grow basis-0 self-stretch bg-no-repeat bg-cover bg-center"
                    style="background-image: url('<?php echo $image; ?>')">
                </span>
            </div>
        </div>
    <?php } else { ?>
        <div class="flex flex-row items-center justify-center px-16 pt-64 first:pt-32">
            <span class="separator"></span>
            <span class="w-2/5 flex flex-col items-center text-contrast">
                <h4><?php echo $section->post_title; ?></h4>
                <?php echo $section->post_content; ?>
            </span>
            <span class="separator"></span>
        </div>
        <?php } ?>
    <?php
        $meta = get_post_meta( $section->ID );
        if( array_key_exists( 'catalog', $meta ) && $meta['catalog'][0] != -1 ) {
            get_template_part('parts/carousel', null, array( 'cat_id' => $meta['catalog'][0] ) );
        };
    } ?>