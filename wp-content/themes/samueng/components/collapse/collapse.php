<?php
// namespace KubioCustomTheme\Components\Collapse;

class CollapseRenderer {
    public function __construct() {
        // Hook để enqueue CSS và JS
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    /**
     * Enqueue CSS và JS cho collapse component
     */
    public function enqueue_assets() {
        // Enqueue CSS
        wp_enqueue_style(
            'collapse-css',
            get_stylesheet_directory_uri() . '/components/collapse/collapse.css',
            array(),
            '1.0.0'
        );

        // Enqueue JavaScript
        wp_enqueue_script(
            'collapse-js',
            get_stylesheet_directory_uri() . '/components/collapse/collapse.js',
            array(),
            '1.0.0',
            true
        );
    }

    /**
     * Render collapse component
     * @param string $label - Tiêu đề của collapse
     * @param string $details - Nội dung chi tiết của collapse
     */
    public function render($label, $details) {
        ?>
        <div class="collapse-group">
            <div class="item-collapse-label">
                <div class="collapse-icons">
                    <span class="collapse-icon collapse-icon-up"></span>
                    <span class="collapse-icon collapse-icon-down"></span>
                </div>
                <?php echo esc_html($label); ?>
            </div>
            <div class="item-collapse-details">
                <?php echo $details; ?>
            </div>
        </div>
        <?php
    }
}