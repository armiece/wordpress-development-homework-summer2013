<?php

/* Plugin Name: AddThis!
Plugin URI: http://addthis.co.ukVersion:0.1
Description: Adds social media icons to single blog post pages, allowing readers to share content.
*/


function addthis_enqueue_scripts() {	
	if ( is_single () && 0 === get_option( ‘addthis_disable_button’ , 0 )  ) {	
		wp_enqueue_script (
			‘addthis_buttons’,
			‘//assets.pintrest.com/js/pinit.js’,
			array(),	
			null,	
			true 
		); 
	} 
}

add_action( ‘wp_enqueue_scripts’, ‘addthis_buttons_scripts’);

function addthis_add_buttons( $content ) {             //adds the buttons to post pages	
	if ( is_single ()	
	if ( is_single () ) {		
		$button_html = ‘<a href=”/pintrest.com/pin/create/button/” data-pin-dp=”buttonBoomark”>’		
		$button_html = ‘<img src=”#” />’		
		$button_html = ‘</a>’		}	
	return $content; }
	
add_filter(‘the_content’, ‘addthis_add_buttons’, 10 ); 

// OPTIONS PAGE

function addthis_add_options_page() {	
	add_options_page(		
		__( ‘AddThis Options’ ), // Names the page		
		__( ‘AddThis Options’ ), //Names the menu selection		
		‘manage_options’,		
		‘addthis_options_page’,		
		‘addthis_render_options_page’, ); } 
		
add_action( ‘admin_menu’, ‘addthis_add_options_page’, 10 );  // Tells the Admin menu to add a link to the AddThis! Option page 

function pimple_render_options_page() {        //HTML Markup for the options page	
	?>		
    <div class=”wrap”>		
	<?php screen_icon(); ?>		
    <h2><?php _e( ‘AddThis Options’ ); ?></h2>		
	<?php settings_field( ‘addthis_disable_button’ ); ?>		
	<?php do_settings_section( ‘addthis_options_page’ ); ?>		
    <p class=”submit”>		
    <input type=”submit” name=”submit” id=”submit” class=”button” />		
    </p>		
    </div>	
    <?php
 } 
 
function addthis_add_disable_button_settings() {	
	register_setting(		
		‘addthis_disable_button’,		
		‘addthis_disable_button’,		
		‘absint’,		
	);			
	
	add_Settings_section (		
		‘addthis_main_settings’,		
		__( ‘AddThis Controls’ ),		
		‘addthis_render_main_settings_section’,		
		‘addthis_options_page’,		
	);	
	
	add_settings_field(		
		‘addthis_disable_button_field’,		
		__( ‘Disable Social Media Buttons’ ),		
		‘addthis_render_disable_button_input’,		
		‘addthis_options_page’,		
		‘addthis_main_settings’,		
	); 
}

add_action ( ‘admin_init’, ‘addthis_add_disable_button_settings’ ); 

function addthis_main_settings_section() {	
	echo “<p>Main settings for this plugin</p>”;
} 

function addthis_render_disable_button_input() {	
	$current = get_option( ‘addthis_disable_button’, 0 );	
	echo “<input name=”addthis_disable_button” ‘ .checked($current, 1, false ) . ‘ type=”checkbox” value=”1? />”
}

