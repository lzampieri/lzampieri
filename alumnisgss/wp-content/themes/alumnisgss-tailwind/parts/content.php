<?php
if( $args['content'] ) { ?>
<div class="flex flex-row items-center justify-center px-16 pt-64 first:pt-32">
    <span class="separator"></span>
    <span class="w-3/6 flex flex-col items-center text-contrast">
        <?php echo apply_filters( 'the_content', $args['content'] ); ?>
    </span>
    <span class="separator"></span>
</div>
<?php } ?>