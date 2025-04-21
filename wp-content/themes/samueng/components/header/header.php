<?php
// filepath: c:\xampp\htdocs\samuelPortfolioProj\wp-content\themes\kubio-custom-theme\components\header\header.php

class HeaderRenderer 
{
    public function __construct() {
        // Hook để enqueue CSS và JS
        add_action('wp_enqueue_scripts', [$this, 'enqueue_header_styles']);
    }

    function enqueue_header_styles() 
    {
        wp_enqueue_style(
            'header-style', 
            get_stylesheet_directory_uri() . '/components/header/header.css', 
            array(), 
            wp_get_theme()->get('Version')
        );
    }

    public function render() 
    {
        ?>

        <header class="custom-header samueng-header-container">

            <!-- Main Menu -->
            <nav class="main-menu main-menu-container">

                <div class="header-content site-content-group">

                    <!-- Website Logo -->
                    <div class="website-logo">
                        <img src="<?php echo esc_url(get_site_icon_url()); ?>" alt="Site Icon" width="150" height="150">
                    </div>
                    
                    <!-- Website Logo -->
                    <div class="website-name">
                        <?php echo esc_html(get_bloginfo('name')); ?>
                    </div>

                </div>

                <?php
                    echo '<div class="menu-wrapper">';
                    if (has_nav_menu('main-menu')) {
                        wp_nav_menu( array(
                            'theme_location' => 'main-menu',
                            'container' => 'nav',
                            'container_class' => 'main-nav',
                            'menu_class' => 'menu',  // Thêm lớp CSS cho menu
                            'fallback_cb' => false   // Nếu không có menu, không hiển thị menu mặc định
                        ) );    
                    }
                    else 
                    {
                        echo "<div>---- menu ----</div>";
                    }
                    echo '</div>';
                ?>
            </nav>

            <!-- Banner -->
            <div class="header-banner">
                <!-- Page Title -->
                <div class="header-title">
                    <?php echo esc_html(the_title()); ?>
                </div>

                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/banner 2.png" alt="Banner">
            </div>



        </header>
        <?php
    }
}