<?php
// addThis_index.php file
$temp = 'button_settings.set';
if (file_exists($temp)) {  // try to open a file for reading, requiring will allow it to be read from
    require_once $temp;
    if ($display_data['right'] == 1) {
        $position == 'right';
    } else {
        $position == 'left';
    }
    if($display_data['number'] != NULL){
        $button_num = $display_data['number'];       
    }
}else {
    $position = 'left';
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

<?php
require_once 'IO.php';
require_once 'settings_display.php';

if (isset($_POST['save_settings'])) {
    write_settings();
} else if ($_POST['change_settings']) {
    display_form();
} else {
    ?>
    <form method="post" action="">     
        <input type="submit" name="change_settings" value="Change Settings" /> 
    </form>   
    <?php
}
// end index.php
?>