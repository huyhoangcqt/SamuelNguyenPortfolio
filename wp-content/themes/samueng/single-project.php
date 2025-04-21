<?php
if ( wp_is_mobile() ) {
    // Include the mobile template
    include get_stylesheet_directory() . '/templates/mobile/single-project-mobile-template.php';
} else {
    // Include the desktop template
    include get_stylesheet_directory() . '/templates/desktop/single-project-desktop-template.php';
}
?>
