<?php
if( $args['content'] ) { ?>
<div class="flex flex-col md:flex-row items-center justify-center px-4 md:px-16 pt-32 md:pt-64 first:pt-32">
    <span class="separator"></span>
    <span class="w-full md:w-3/5 text-center text-dark-tx">
        <?php echo apply_filters( 'the_content', $args['content'] ); ?>
    </span>
    <span class="separator"></span>
</div>
<?php } ?>