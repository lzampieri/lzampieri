<div class="h-screen flex flex-col items-center justify-center">
    <div class="flex flex-row h-4/6 w-4/6 items-center">
        <span class="text-contrast grow basis-0">
            <h1><?php echo str_replace( " ", "<br />", get_bloginfo('name') ); ?></h1>
            <?php if( !empty( get_bloginfo('description') ) ) { ?>
                <h4 class="text-light mt-3"><?php echo get_bloginfo('description'); ?> </h4>
            <?php } ?>
        </span>
        <span class="separator"></span>
        <span class="grow basis-0 h-full aspect-square">
            <img class="h-full" src="<?php echo get_template_directory_uri(); ?>/assets/logo_contrast.svg" />
        </span>
    </div>
</div>