<!-- AddThis Smart Layers BEGIN -->
<!-- Go to http://www.addthis.com/get/smart-layers to customize -->
<?php
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
/* Plugin Name: AddThis!
  Plugin URI: http://addthis.co.ukVersion:0.1
  Description: Adds social media icons to single blog post pages, allowing readers to share content.
 */

function addthis_enqueue_scripts() {

    if (is_single() && 0 === get_option('addthis_disable_button', 0)) {
        wp_enqueue_script('addthis_buttons', '//assets.pintrest.com/js/pinit.js', array(), null, true);
    }
}

add_action('wp_enqueue_scripts', 'addthis_buttons_scripts');

function addthis_add_buttons($content) {             //adds the buttons to post pages	
    if (is_single()) {
        $button_html .= '<a href="/pintrest.com/pin/create/button/" data-pin-dp="buttonBoomark">';
        $button_html .= '<img src="#" />';
        $button_html .= '</a>';
    }
    return $content;
}

add_filter('the_content', 'addthis_add_buttons', 10);

// OPTIONS PAGE

function addthis_add_options_page() {
    add_options_page(
    __( 'AddThis Options' ), // Names the page		
    __( 'AddThis Options' ), //Names the menu selection		
    'manage_options',
    'addthis_options_page',
    'addthis_render_options_page',
    );
}

add_action('admin_menu', 'addthis_add_options_page', 10);  // Tells the Admin menu to add a link to the AddThis! Option page 

function pimple_render_options_page() {        //HTML Markup for the options page	
    ?>		
    <div class="wrap">		
        <?php screen_icon(); ?>		
        <h2><?php _e('AddThis Options'); ?></h2>		
        <?php settings_field('addthis_disable_button'); ?>		
        <?php do_settings_section('addthis_options_page'); ?>		
        <p class="submit">		
            <input type="submit" name="submit" id="submit" class="button" />		
        </p>		
    </div>	
    <?php
}

function addthis_add_disable_button_settings() {

    register_setting(
    'addthis_disable_button',
    'addthis_disable_button',
    'absint',
    );

    add_Settings_section (
    'addthis_main_settings',
    __('AddThis Controls'),
    'addthis_render_main_settings_section',
    'addthis_options_page',
    );

    add_settings_field(
    'addthis_disable_button_field',
    __('Disable Social Media Buttons' ),
    'addthis_render_disable_button_input',
    'addthis_options_page',
    'addthis_main_settings',
    );
}

add_action('admin_init', 'addthis_add_disable_button_settings');

function addthis_main_settings_section() {
    echo "<p>Main settings for this plugin</p>";
}

function addthis_render_disable_button_input() {

    $current = get_option('addthis_disable_button', 0);
    echo '<input id="addthis-disable-button" name="addthis_disable_button" type="checkbox" value="1" ' . checked(1, $current, false) . ' />';
}
