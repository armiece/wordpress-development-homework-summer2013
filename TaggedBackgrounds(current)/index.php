<?php
/*
  Plugin Name: TaggedBackgrounds
  Plugin URI: http://taggedbg.co.uk
  Version:0.1
  Description: Gives users the ability to specify background images for inidivual post pages based on tags.
  Author: Slip
  Author URI: http://dragonsdenstudios.com/
  ----------------------------------------------------------------------------- */

add_action( is_single, taggedbg_findtags );

function taggedbg_findtags() {
        if (is_single()) {

            $temp_tags = array();
            $temp_tags = get_the_tags();

            if (count($temp_tags) > 1) {
                echo '<xmp>' . var_export($temp_tags, true) . "</xmp>\n";
                // Default CSS Settings here
            } else if (count($temp_tags) == 1) {
                $bg_url = get_option($temp_tag);

                echo "$bg_url<br>";
            }
        }
}

/* ADMIN PAGE ---------------------------------------------------------------- */

add_action('admin_menu', 'taggedbg_admin_actions');

function taggedbg_admin_actions() {
    add_options_page('Tagged Backgrounds', 'Tagged Backgrounds', 'manage_options', __FILE__, 'taggedbg_admin');
}

function taggedbg_admin() {

    $tags = get_tags();
    ?>
    <div class="wrap">
        <h2>Tagged Backgrounds Options</h2>        


        <form action="" method="post">
                <label><strong>Available Tags</strong></label><br />
                <i>Your existing tags are available here. To add a new tag to this list, they must be applied to an existing blog post.</i><br />
        <?php
        if (isset($_POST['aeh_tags_submit'])) {
            $tag_array = array();
            $tag_array = $_POST['Tag'];
            ?>                                

            <select name="Tag" id="aeh_tag_list">
                    <?php
                    foreach ($tags as $tag) {
                        if ($tag->name == esc_textarea($tag_array)) {
                            ?><option selected value="<?php echo $tag->name ?>"><?php echo $tag->name ?></option><?php
                        } else {
                            ?><option value="<?php echo $tag->name ?>"><?php echo $tag->name ?></option><?php
                        }
                    }
                    ?>
                </select>

                <input type="submit" name="aeh_tags_submit" value="Select Tag" />  
            </form>
            <i>You selected: <span style="font:15pt; color:#900; font-weight:bold;"><?php echo $tag_array ?></span></i>
            <br /><br />

            <form action="" method="post">
                <label><strong>Background Image</strong></label><br />
                <i>Choose a background by submitting an image url.</i><br />
                <input type="text" name="aeh_background[<?php echo 'url' ?>]" /> 
                <input type="hidden" name="aeh_background[<?php echo 'tag' ?>]" size="15" value="<?php echo $tag_array ?>" />
                <input type="submit" name="aeh_bg_submit" value="Select Background" />    
            </form>
            <?php
        } else if (isset($_POST['aeh_bg_submit'])) {

            $tag_url_array = array();
            $tag_url_array = $_POST['aeh_background'];

            $cleaned_url = sanitize_text_field($tag_url_array['url']);
            $temp_tag = sanitize_text_field($tag_url_array['tag']);

            echo "$temp_tag<br>";


            update_option($temp_tag, $cleaned_url);
            $bg_url = get_option($temp_tag);

            echo "$bg_url<br>";
        } else {
            ?>


            <form action="" method="post">
                
                <select name="Tag" id="aeh_tag_list">
                    <?php
                    foreach ($tags as $tag) {
                        ?>
                        <option value="<?php echo $tag->name ?>"><?php echo $tag->name ?></option>
                        <?php
                    }
                    ?>
                </select>
                <input type="submit" name="aeh_tags_submit" value="Select Tag" />

            </form>






        </div>
        <?php
    }
}
?>