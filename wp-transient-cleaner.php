<?php
    /*
    Plugin Name: Vondrakk's Transient Cleaner
    Plugin URI: http://vondrakk.wordpress.com
    Description: Plugin for cleaning transient files
    Author: Viktor von Drakk
    Version: 1.0
    Author URI: http://vondrakk.wordpress.com
    */
add_action( 'admin_menu', 'transient_cleaner_menu' );

function transient_cleaner_menu() {
        add_options_page( 'Tranient Cleaner', 'Transient Cleaner', 'manage_options', 'transient-cleaner-options', 'transient_cleaner_options' );
}

function transient_cleaner_options() {
        if ( !current_user_can( 'manage_options' ) )  {
                wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }

global $wpdb;

if( isset($_POST[ 'Submit' ]) && $_POST[ 'Submit' ] == 'Clean Transients' ) {
        $wpdb->query("DELETE FROM wp_options WHERE option_name LIKE '%transient%'");
}

$results = $wpdb->get_results( "SELECT option_name FROM wp_options WHERE option_value like '%transient%'",ARRAY_N );

$tcount=sizeof($results);
        echo '<div class="wrap">';
        echo '<p>Number of Transients in the database: '.$tcount.'.</p>';
        echo '<ol>';
for ($j=0;$j<sizeof($results);$j++) {
        echo '<li>'.$results[$j][0].'</li>';
}
        echo '</div>';
?>

<form name="form1" method="post" action="">

<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="Clean Transients" />
</p>

</form>
</div>

<?php

}
