<?php
/*
Plugin Name: Bye Bye Bye Lines
Plugin URI:  http://www.nsync.com/
Description: Display a byline at the end of a post, making it a Bye bye bye line.
Version:     1.0
Author:      'N Sync
Author URI:  http://www.nsync.com/
License:     GPLv2 or later
*/


/**
 * Set up the metabox.
 *
 * @param  string    $post_type    The post type.
 * @param  object    $post         The current post object.
 * @return void
 */

function bbl_call_meta_box( $post_type, $post ) { // Fuction renamed
	add_meta_box(
		'byebyebye_line',
		__( 'Bye Bye Bye Line', 'byebyebye_lines' ),
		'bbl_display_meta_box',
		'post',
		'side',
		'high'
	);
}

add_action( 'add_meta_box', 'bbl_call_meta_box', 10, 2 );  //Function 'add_meta_boxes' name incorrect, renamed

/**
 * Display the HTML for the metabox.
 *
 * @param  object    $post    The current post object
 * @param  array     $args    Additional arguments for the metabox.
 * @return void
 */

function bbl_display_meta_box( $post, $args ) { // Function renamed
?>
	<p>
		<label for="byeline">
			<?php _e( 'Bye Bye Bye Line', 'byebyebye_lines' ); ?>:&nbsp;
		</label>
		<input type="text" class="widefat" name="byeline" value="" />
		<em>
			<?php _e( 'HTML is not allowed', 'byebyebye_lines' ); ?>
		</em>
	</p>
<?php
}

/**
 * Save the metabox.
 *
 * @param  int       $post_id    The ID for the current post.
 * @param  object    $post       The current post object.
 */

function bbl_save_meta_box( $post_id, $post ) { // Function renamed
	if ( ! isset( $_POST['byeline'] ) ) {
		return;
	}

	$byeline = $_POST['byeline'];

	$clean_value = sanitize_text_field( $byeline); //changed, sanitizes the user input field before entering it as a meta

	update_post_meta( $post_id, 'byebyebye-line', /*$byeline*/ $clean_value );
}

add_action( 'save_post', 'bbl_save_meta_box', 10, 2 );

/**
 * Append the Bye Bye Bye Line to the content.
 *
 * @param  string    $content    The original content.
 * @return string                The altered content.
 */

function print_byebyebye_line( $content ) { // Function name left unchanged, not likely to be used
	$byebyebye_line = get_post_meta( get_the_ID(), 'byebyebye-line', true );
	return $content . $byebyebye_line;
}

add_filter( 'the_content', 'print_byebyebye_line' );
