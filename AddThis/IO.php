<?php

// save settings file,    IO.php
function write_settings() {
    $write_set = $_POST['display_data'];
    $save = "<?php\n\$saved_shows= " . var_export($write_set, true) . ";\n?>\n";

    $file_name = 'button_settings.set';
    $file_handler = fopen($file_name, 'w');

    fputs($file_handler, $save);
    fclose($file_handler);
}

// end IO.php
?>