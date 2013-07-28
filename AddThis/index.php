<?php
/* Plugin Name: AddThis!
  Plugin URI: http://addthis.co.uk
  Version:0.1
  Description: Adds social media icons to single blog post pages, allowing readers to share content.
 */



if (isset($_POST['button_name'])) {

    function set_js($position, $button_num) {
        if ($position != "right" && $position != "left") {
            $position = 'left';
        }
        if ($button_num < 1) {
            $button_num = 6;
        }
        ?>
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-51f2cc511604929f"></script>
        <script type="text/javascript">
            addthis.layers({
                'theme' : 'transparent',
                'share' : {
                    'position' : '<?php echo $position ?>',  <!-- Right/Left (Default:Left) -->
                    'numPreferredServices' : <?php echo $button_num ?> <!-- Button Amount (Default: 6) -->
                }
            });
        </script>
        <!-- AddThis Smart Layers END -->

        <?php
    }

}
?>


<?php

function addthis_enqueue_scripts() {

    if (is_single() && 0 === get_option('addthis_disable_button', 0)) {
        wp_enqueue_script('addthis_buttons');
    }
}

add_action('wp_enqueue_scripts', 'addthis_buttons_scripts');

function addthis_add_buttons($content) {             //adds the buttons to post pages	
    if (is_single()) {
    }
    return $content;
}

add_filter('the_content', 'addthis_add_buttons', 10);

//add_menu_page


add_action('admin_menu', 'addthis_create_menu');

function addthis_create_menu() {

	//create new top-level menu
	add_menu_page('AddThis! Plugin Settings', 'AddThis! Settings', 'administrator', __FILE__, 'addthis_settings_page',plugins_url('/img/AddThis_Icon.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'addthis_register_mysettings' );
}


function register_mysettings() {
	//register our settings
	register_setting( 'addthis-settings-group', 'new_option_name' );
	register_setting( 'addthis-settings-group', 'some_other_option' );
	register_setting( 'addthis-settings-group', 'option_etc' );
}

function addthis_settings_page() {
?>
<div class="wrap">
<h2>AddThis! Settings</h2>

<form method="post" action="../../../../Desktop/slip/wp-content/plugins/AddThis/index.php">
    <?php settings_fields( 'addthis-settings-group' ); ?>
    <?php do_settings( 'addthis-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">New Option Name</th>
        <td><input type="text" name="new_option_name" value="<?php echo get_option('new_option_name'); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Some Other Option</th>
        <td><input type="text" name="some_other_option" value="<?php echo get_option('some_other_option'); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Options, Etc.</th>
        <td><input type="text" name="option_etc" value="<?php echo get_option('option_etc'); ?>" /></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php } ?>