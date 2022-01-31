<?php
class ASGSSR_PagesRights {

    public function __construct()
    {
        add_action( 'add_meta_boxes', [$this, 'add_custom_meta_boxes'] );
    }

    public function add_custom_meta_boxes( ) {
        add_meta_box( 'asgssr_reserved', 'Pagina riservata', [$this, 'reserved_meta_box_html'] );
    }

    public function reserved_meta_box_html() {
        ?>
        <label for="asgssr_reserved">Pagina riservata</label>
        <select name="asgssr_reserved_field" id="asgssr_reserved_field">
            <option value="false">Pubblica</option>
            <option value="true">Riservata</option>
        </select>
        <?php    
    }

}