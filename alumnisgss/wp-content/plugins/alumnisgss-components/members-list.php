<?php
namespace alumnisgss_components_members_list;

function activate () {
    add_option( 'alumnisgss_components_memberslist', '[["Coorte","Nome","Studente","Sostenitore"]]' );
}

function deactivate () {
    delete_option( 'alumnisgss_components_memberslist' );
    
}

function register_hooks () {
    add_action( 'admin_menu', 'alumnisgss_components_members_list\add_admin_page' );
    add_action('init','alumnisgss_components_members_list\csv_pack');
    add_action('init','alumnisgss_components_members_list\register_shortcode');
}

function add_admin_page() {
    add_submenu_page(
        'alumnisgss_components_admin',
        'Lista dei membri',
        'Membri',
        'manage_options',
        'members',
        'alumnisgss_components_members_list\admin_page_content'
    );
}

function admin_page_content() {
    if( isset( $_FILES['member_list_upload'] ) ) {
        csv_unpack( $_FILES['member_list_upload'] );
    }
    
    $members = json_decode( get_option( 'alumnisgss_components_memberslist' ) );

?>
    <h1>Membri registrati</h1>
    <h4>Ricorda: basta inserire lo shortcode <code>[alumnisgss_members]</code> in una qualsiasi pagina, articolo o sezione per far comparire la lista degli alumni.</h4>
    <form method="post" enctype="multipart/form-data">
        <h3>Carica nuova lista</h3>
        <input type="file" name="member_list_upload" id="member_list_upload" />
        <input type="submit" value="Carica!" />
    </form>
    <form method="post" enctype="multipart/form-data">
        <h3>Scarica lista attuale</h3>
        <input type="hidden" name="member_list_download" id="member_list_download" />
        <input type="submit" value="Scarica" />
    </form>
    
    <br/><br/>
    <h3>Lista attualmente caricata:</h3>
    <table>
        <thead>
            <tr>
                <?php
                    foreach( $members[0] as $key ) {
                        echo "<th>" . $key . "</th>";
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach( array_slice( $members, 1) as $member ) {
                echo "<tr>";
                foreach( $member as $item ) {
                    echo "<td>" . $item . "</td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
<?php

}

function csv_unpack( $thefile ) {
    echo '<h2>Caricamento del file...</h2>';
    if ( $thefile["error"] > 0) {
        echo '<h3>C\'è stato un errore nel caricamento del file. Si prega di riprovare.</h3>';
        return;
    }
    echo '<h3>Caricamento completato.</h3>';

    $filestream = fopen( $thefile["tmp_name"], "rb" );
    $header = fgetcsv( $filestream, "1024" );
    $row = 1;
    if( $header != array ( "Coorte", "Nome", "Studente", "Sostenitore" ) ) {
        echo '<h3>File mal formattato alla riga ' . $row . '</h3>';
        return;
    }

    $data = [];
    $data[] = $header;

    while( $line = fgetcsv( $filestream, "4096" ) ) {
        $row ++;
        $line = array_map("utf8_encode", $line);
        if( count( $line ) != 4 or !is_numeric( $line[0] ) or !( $line[2] == "" or $line[2] == "S" ) or !( $line[3] == "" or $line[3] == "S" ) ) {
            echo '<h3>File mal formattato alla riga ' . $row . '</h3>';
            return;
        }
        $data[] = $line;
    }

    usort( $data, 'alumnisgss_components_members_list\members_sort' );

    update_option( 'alumnisgss_components_memberslist', json_encode( $data ) );
    echo '<h3>Salvataggio completato.</h3>';
}

function members_sort( $a, $b ) {
    $a_s = is_numeric( $a[0] ) ? $a[0] : 0;
    $b_s = is_numeric( $b[0] ) ? $b[0] : 0;
    return $a_s - $b_s;
}

function csv_pack( ) {
    if( !isset( $_POST['member_list_download'] ) ) {
        return;
    }

    $members = json_decode( get_option( 'alumnisgss_components_memberslist' ) );
    $filestream = fopen('php://memory', 'w'); 
    // loop over the input array
    foreach( $members as $line ) { 
        fputcsv( $filestream, $line ); 
    }
    fseek( $filestream, 0 );

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="alumni.csv";');
    fpassthru($filestream);
    exit();    
}

function register_shortcode() {
    add_shortcode( 'alumnisgss_members', 'alumnisgss_components_members_list\parse_shortcode' );
}

function parse_shortcode() {
    $members = json_decode( get_option( 'alumnisgss_components_memberslist' ) );
    $output = "<div class=\"alumnisgss_members\">";
    $coorte = 0;
    foreach( array_slice( $members, 1) as $member ) {
        if( $member[0] != $coorte ) {
            $coorte = $member[0];
            if( $coorte != 0 ) $output .= "</dl>";
            $output .= "<dl><dt>" . $coorte . "° Coorte </dt>";
        }
        $output .= "<dd class=\"" . ( $member[2] == "S" ? " alumnisgss_members_students" : "" ) . ( $member[3] == "S" ? " alumnisgss_members_supporter" : "" ) . "\">" . $member[1] . "</dd>";
    }
    $output .= "</div>";
    return $output;
}