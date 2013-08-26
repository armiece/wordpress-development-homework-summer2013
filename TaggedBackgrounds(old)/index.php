<?php
/* Plugin Name: TaggedBackgrounds
  Plugin URI: http://taggedbg.co.uk
  Version:0.1
  Description: Gives users the ability to specify background images for inidivual post pages based on tags.
  Author: Slip
  Author URI: http://dragonsdenstudios.com/
 ----------------------------------------------------------------------------- */

add_action('admin_menu', 'taggedbg_admin_actions');

function taggedbg_admin_actions() {
	add_options_page('Tagged Backgrounds', 'Tagged Backgrounds', 'manage_options', __FILE__, 'taggedbg_admin');	
}

function taggedbg_admin() {
		?>
        <div class="wrap">
        <h2>Tagged Backgrounds Options</h2>
        <p>Hello world!</p>
        
       
        <?php
			global $wpdb;

			        $mytestdrafts = $wpdb->get_results(
        			"
        				SELECT *
        				FROM $wpdb->terms NATURAL JOIN $wpdb->term_taxonomy
    						WHERE taxonomy = 'post_tag'
        			"   ,   ARRAY_A   
       				);
					
					
					$tag_array = array();
		?>

		<table class="widefat">
        	<thead><tr><th>Your Tags</th></tr></thead>
			<?php
			for ($i=0; $i<count($mytestdrafts); $i++) {
				$tag_array[]= $mytestdrafts[$i]['name'];
				echo "<tr><td>{$tag_array[$i]}</td></tr>";	
			}
	

			?>
 		</table>
        
        
        
        </div>
        <?php
}


?>