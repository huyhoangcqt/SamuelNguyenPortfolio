
<?php

// Import class CollapseRenderer
require_once get_stylesheet_directory() . '/components/header/header.php';
require_once get_stylesheet_directory() . '/components/collapse/collapse.php';
require_once get_stylesheet_directory() . '/helpers/project-renderer.php';
require_once get_stylesheet_directory() . '/helpers/portfolio-renderer.php';

$header_renderer = new HeaderRenderer();
$collapse_renderer = new CollapseRenderer();
$project_renderer = new ProjectRenderer($collapse_renderer);
$portfolio_renderer = new PortfolioRenderer();

// Hàm để lấy đối tượng CollapseRenderer
function get_collapse_renderer() {
    global $collapse_renderer;
    return $collapse_renderer;
}

//include css

function my_theme_enqueue_styles() 
{
    wp_enqueue_style( "samueng-style", get_template_directory_uri() . '/style.css' );

    wp_enqueue_style(
        'page-contact-style',
        get_stylesheet_directory_uri() . '/css/page-contact.css',
        array(),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );


//include js
function custom_enqueue_scripts() 
{
    //my code
    // wp_enqueue_script('collapse-js', get_stylesheet_directory_uri() . '/js/collapse.js', array(), null, true);
    
    
    if (is_post_type_archive('project')) {
        wp_enqueue_script(
            'search_bar', // Tên định danh
            get_stylesheet_directory_uri() . '/js/search_bar.js', // Đường dẫn tới file search_bar.js
            array('jquery'), // Phụ thuộc vào jQuery (nếu cần)
            null, // Phiên bản (null để tự động lấy phiên bản)
            true // Đặt true để tải script ở footer
        );

        // Truyền biến `ajaxurl` cho JavaScript
        wp_localize_script('search_bar', 'ajaxurl', admin_url('admin-ajax.php'));
    }

    // Truyền biến `ajaxurl` cho JavaScript
    wp_localize_script('search_bar', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'custom_enqueue_scripts');



function enqueue_highlight_js() {
    // Thêm Highlight.js
    wp_enqueue_script('highlight-js', 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js', array(), null, true);
    // Thêm theme nền tối (ví dụ: Atom One Dark)
    wp_enqueue_style('highlight-js-dark-theme', 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/atom-one-dark.min.css', array(), null);
    // Kích hoạt Highlight.js
    wp_add_inline_script('highlight-js', 'hljs.highlightAll();');
}
add_action('wp_enqueue_scripts', 'enqueue_highlight_js');



function samueng_register_menus() {
    register_nav_menus(array(
        'main-menu' => __('Main Menu', 'samueng'), // Đăng ký menu chính
        'footer-menu' => __('Footer Menu', 'samueng'), // Đăng ký menu footer (nếu cần)
    ));
}
add_action('after_setup_theme', 'samueng_register_menus');


function filter_projects() {
    $search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
    $rating = isset($_GET['rating']) ? intval($_GET['rating']) : 0;
    $sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'start_time_asc';

    $meta_query = array();
    if ($rating > 0) {
        $meta_query[] = array(
            'key'     => 'rating',
            'value'   => $rating,
            'compare' => '>=',
            'type'    => 'NUMERIC',
        );
    }

    $orderby = 'meta_value';
    $meta_key = 'project_start';
    $order = 'ASC';

    if ($sort === 'start_time_desc') {
        $order = 'DESC';
    } elseif ($sort === 'rating_desc') {
        $orderby = 'meta_value_num';
        $meta_key = 'rating';
        $order = 'DESC';
    } elseif ($sort === 'rating_asc') {
        $orderby = 'meta_value_num';
        $meta_key = 'rating';
        $order = 'ASC';
    }

    $args = array(
        'post_type'      => 'project',
        'posts_per_page' => -1,
        's'              => $search,
        'meta_query'     => $meta_query,
        'orderby'        => $orderby,
        'meta_key'       => $meta_key,
        'order'          => $order,
    );

    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            ?>
            <article class="project-item">
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <p>Rating: <?php echo get_post_meta(get_the_ID(), 'rating', true); ?></p>
                <div class="thumbnail">
                    <?php if (has_post_thumbnail()) {
                        the_post_thumbnail('medium');
                    } ?>
                </div>
                <p><?php the_excerpt(); ?></p>
            </article>
            <?php
        endwhile;
    else :
        echo '<p>No projects found.</p>';
    endif;
    wp_reset_postdata();

    $html = ob_get_clean();
    wp_send_json(array('html' => $html));
}
add_action('wp_ajax_filter_projects', 'filter_projects');
add_action('wp_ajax_nopriv_filter_projects', 'filter_projects');



function format_code_lang($code, $language) {
    if (empty($code)) {
        return ''; // Nếu không có code, trả về chuỗi rỗng
    }

    // Trả về HTML đã được định dạng
    return '<pre><code class="language-' . esc_attr($language) . '">' . esc_html($code) . '</code></pre>';
}


function enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');






// Thêm suffix ngôn ngữ vào menu item title chỉ trong wp-admin nav-menus.php
function add_language_suffix_to_admin_menu_item_title($title, $item, $args, $depth) {
    // Kiểm tra nếu chúng ta đang ở trong admin area
    if (is_admin()) {
        // Lấy ngôn ngữ từ custom field của menu item
        $language = get_post_meta($item->object_id, '_page_language', true);
        
        // Kiểm tra và thêm thông tin ngôn ngữ vào title (suffix) trong admin menu
        if ($language) {
            $language_label = ($language == 'vi') ? ' (Tiếng Việt)' : ' (English)';
        }
        else 
            $title .= ' (Tiếng Việt) ';
    }

    return $title;
}
add_filter('nav_menu_item_title', 'add_language_suffix_to_admin_menu_item_title', 10, 4);





function get_label_selected_field($field_name, $post_id)
{
    $programming_languages = get_field($field_name, $post_id);
    $field_object = get_field_object($field_name, $post_id); // Lấy thông tin chi tiết của trường
    if (!empty($programming_languages) && is_array($programming_languages)) {
        $language_labels = array();

        foreach ($programming_languages as $language_value) {
            if (isset($field_object['choices'][$language_value])) {
                $language_labels[] = $field_object['choices'][$language_value]; // Lấy label tương ứng
            }
        }

        // Hiển thị danh sách các label
        return esc_html(implode(', ', $language_labels));
    }
    else {
        return '';
    }
}
