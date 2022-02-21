<div class="flex flex-row w-full items-center p-8">
    <span class="text-contrast grow-0 w-1/3">
        <h4><?php echo get_bloginfo('name'); ?></h4>
        <?php if( !empty( get_bloginfo('description') ) ) {
            echo get_bloginfo('description');
        } ?>
    </span>
    <span class="grow"></span>
    <span class="separator"></span>
    <span class="grow"></span>
    <span
        class="grow-0 w-1/3 self-stretch bg-no-repeat bg-contain bg-right"
        style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/logo_contrast.svg')">
    </span>
</div>