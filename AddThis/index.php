<?php
/* Plugin Name: AddThis!
  Plugin URI: http://addthis.co.uk
  Version:1.0
  Description: Adds social media icons to single blog post pages, allowing readers to share content.
  Author: Slip
  Author URI: http://dragonsdenstudios.com/
 ----------------------------------------------------------------------------- */



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


add_action('admin_menu', 'addthis_admin_actions');

function addthis_admin_actions() {
	//create new sub-level menu
	add_options_page('AddThis! Plugin Settings', 'AddThis! Plugin', 'manage_options', __FILE__, 'addthis_admin',plugins_url('/img/AddThis_Icon.png', __FILE__));

}

function addthis_admin() {
?>
    <div class="wrap">
	<h2>AddThis! Settings and Options</h2>
	Options available to the AddThis! Plugin.
	<form action="../../../../Desktop/slip/wp-content/plugins/AddThis/options.php" method="post">
	<?php settings_fields('addthis_options'); ?>
	<?php do_settings_sections('addthis'); ?>
 
	<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
	</form>
    </div>
<?php }


add_action('admin_init', 'addthis_admin_init');

function addthis_admin_init(){
	register_setting( 'addthis_options', 'addthis_options', 'addthis_options_validate' );
	add_settings_section('addthis_main', 'Main Settings', 'addthis_section_text', 'addthis');
	add_settings_field('addthis_text_string', 'AddThis! Text Input', 'addthis_setting_string', 'addthis', 'addthis_main');
}

function addthis_section_text() {
	echo '<p>Main description of this section here.</p>';
} 

function addthis_setting_string() {
	$options = get_option('addthis_options');
	echo "<input id='addthis_text_string' name='addthis_options[text_string]' size='40' type='text' value='{$options['text_string']}' />";
} 


function addthis_options_validate($input) {
	$newinput['text_string'] = trim($input['text_string']);
	if(!preg_match('/^[a-z0-9]{32}$/i', $newinput['text_string'])) {
	$newinput['text_string'] = ''; }
	return $newinput;
}


function addthis_add_disable_button_setting() {
    // Register a binary value called "addthis_disable"
    register_setting(
        'addthis_disable_button',
        'addthis_disable_button',
        'absint'
    );

    // Add the settings section to hold the interface
    add_settings_section(
        'addthis_main_settings',
        __( 'Pimpletrest Controls' ),
        'addthis_render_main_settings_section',
        'addthis_options_page'
    );

    // Add the settings field to define the interface
    add_settings_field(
        'addthis_disable_button_field',
        __( 'Disable Pinterest Buttons' ),
        'addthis_render_disable_button_input',
        'addthis_options_page',
        'addthis_main_settings'
    );
}

add_action( 'admin_init', 'addthis_add_disable_button_setting' );

function addthis_render_disable_button_input() {
    // Get the current value
    $current = get_option( 'addthis_disable_button', 0 );
    echo '<input id="addthis-disable-button" name="addthis_disable_button" type="checkbox" value="1" ' . checked( 1, $current, false ) . ' />';
}

?>