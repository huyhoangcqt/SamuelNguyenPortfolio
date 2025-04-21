
<?php if (have_posts()) : ?>
        <div class="project-list">
            <?php while (have_posts()) : the_post(); ?>
                <article class="project-item">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p>Rating: <?php echo get_post_meta(get_the_ID(), 'rating', true); ?></p>
                    <div class="thumbnail">
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('medium');
                        } ?>
                    </div>
                    <p><?php the_excerpt(); ?></p>
                </article>
            <?php endwhile; ?>
        </div>

        <!-- Hiển thị pagination -->
        <div class="pagination">
            <?php the_posts_pagination(); ?>
        </div>

    <?php else : ?>
        <p>Không có dự án nào.</p>
    <?php endif; ?>










<div>Không hiển thị các project có rating < 5</div>

    <header class="archive-header">
        <h1 class="archive-title">All Projects</h1>
    </header>

    <div class="all-projects">
        <?php
        $all_projects = new WP_Query(array(
            'post_type'      => 'project',
            'posts_per_page' => 10,
            'meta_key'       => 'rating',  // Trường custom field "rating"
            'orderby'        => 'meta_value_num', // Sắp xếp theo giá trị số
            'order'          => 'DESC',  // Rating cao nhất trước
            'meta_query'     => array(
                array(
                    'key'     => 'rating',  // Trường custom field "rating"
                    'value'   => 5,        // Giá trị tối thiểu
                    'compare' => '>=',     // Lấy các bài viết có rating >= 5
                    'type'    => 'NUMERIC' // Kiểu dữ liệu là số
                )
            )
        ));

        if ($all_projects->have_posts()) :
            while ($all_projects->have_posts()) : $all_projects->the_post();
        ?>
                <article class="all-project">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
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
        endif;
        wp_reset_postdata();
        ?>
    </div>














    <div>Hiển thị top 4 project có rating cao nhất</div>
    <div class="highlighted-projects">
        <?php
        $highlighted_projects = new WP_Query(array(
            'post_type'      => 'project',
            'posts_per_page' => 4,
            'meta_key'       => 'rating',  // Trường custom field "rating"
            'orderby'        => 'meta_value_num', // Sắp xếp theo giá trị số
            'order'          => 'DESC',  // Rating cao nhất trước
        ));

        if ($highlighted_projects->have_posts()) :
            while ($highlighted_projects->have_posts()) : $highlighted_projects->the_post();
        ?>
                <article class="highlighted-project">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
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
        endif;
        wp_reset_postdata();
        ?>
    </div>







    <div>Hiển thị các project group by Year</div>
    <div class="all-projects">
        <?php
        $all_projects = new WP_Query(array(
            'post_type'      => 'project',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => 'rating',  // Trường custom field "rating"
                    'value'   => 5,        // Giá trị tối thiểu
                    'compare' => '>=',     // Lấy các bài viết có rating >= 5
                    'type'    => 'NUMERIC' // Kiểu dữ liệu là số
                )
            ),
            'orderby'        => 'meta_value', // Sắp xếp theo custom field
            'meta_key'       => 'project_start', // Trường custom field "start_time"
            'order'          => 'ASC'        // Sắp xếp tăng dần theo thời gian bắt đầu
        ));

        if ($all_projects->have_posts()) :
            $projects_by_year = array();
        
            // Nhóm bài viết theo năm
            while ($all_projects->have_posts()) : $all_projects->the_post();
                $project_start = get_post_meta(get_the_ID(), 'project_start', true);
                $year = date('Y', strtotime($project_start)); // Lấy năm từ project_start
        
                if (!isset($projects_by_year[$year])) {
                    $projects_by_year[$year] = array();
                }
        
                $projects_by_year[$year][] = array(
                    'title' => get_the_title(),
                    'permalink' => get_permalink(),
                    'rating' => get_post_meta(get_the_ID(), 'rating', true),
                    'thumbnail' => has_post_thumbnail() ? get_the_post_thumbnail(get_the_ID(), 'medium') : '',
                    'excerpt' => get_the_excerpt()
                );
            endwhile;
        
            // Hiển thị bài viết theo năm
            echo '<div class="projects-container">';
            foreach ($projects_by_year as $year => $projects) {
                echo '<div class="project-row">';
                // Cột bên trái: Năm
                echo "<div class='project-year'><h2>$year</h2></div>";
        
                // Cột bên phải: Thông tin dự án
                echo "<div class='project-details'>";
                foreach ($projects as $project) {
                    echo "<article class='project-item'>";
                    echo "<h3><a href='{$project['permalink']}'>{$project['title']}</a></h3>";
                    echo "<p>Rating: {$project['rating']}</p>";
                    echo "<div class='thumbnail'>{$project['thumbnail']}</div>";
                    echo "<p>{$project['excerpt']}</p>";
                    echo "</article>";
                }
                echo "</div>"; // Kết thúc cột bên phải
                echo "</div>"; // Kết thúc hàng
            }
            echo '</div>'; // Kết thúc container
        
        else :
            echo "<p>Không có dự án nào.</p>";
        endif;
        
        wp_reset_postdata();
        ?>
    </div>














    <div>Print ra giá trị field mutiple select acf</div>
    <?php
        $field = get_field_object('platforms'); // Lấy thông tin chi tiết của trường platforms

        if ($field) {
            $platforms = $field['value']; // Lấy các giá trị đã chọn
            $choices = $field['choices']; // Lấy danh sách các cặp value => label

            if (!empty($platforms)) {
                // Lấy label tương ứng với các value đã chọn
                $labels = array_map(function($value) use ($choices) {
                    return isset($choices[$value]) ? $choices[$value] : $value; // Kiểm tra tồn tại của label
                }, $platforms);

                // Hiển thị các label đã chọn
                echo '<p><strong>Platforms:</strong> ' . esc_html(implode(', ', $labels)) . '</p>';
            } else {
                // Không có giá trị nào được chọn
                echo '<p><strong>Platforms:</strong> No platforms selected.</p>';
            }
        } else {
            // Trường platforms không tồn tại hoặc không được định nghĩa
            echo '<p><strong>Platforms:</strong> Field not found.</p>';
        }
    ?>







<?php
var_dump($field); // In ra toàn bộ nội dung của biến $field
die(); // Dừng thực thi để kiểm tra kết quả
?>
















<h3>Contributes:</h3>
    <?php
    if (have_rows('feature_1')): // Kiểm tra nếu field group feature_1 có dữ liệu
        while (have_rows('feature_1')): the_row(); // Lặp qua từng hàng trong field group
            $feature_label = get_sub_field('feature_label'); // Lấy giá trị của sub-field feature_label
            $demo_video = get_sub_field('demo_video'); // Lấy giá trị của sub-field demo_video
            $feature_description = get_sub_field('feature_description'); // Lấy giá trị của sub-field feature_description
            $code_snippet = get_sub_field('code_snippet'); // Lấy giá trị của sub-field code_snippet
            $code_explain = get_sub_field('code_explain'); // Lấy giá trị của sub-field code_explain

            // Hiển thị các sub-field
            echo '<div class="feature-item">';
            if (!empty($feature_label)) {
                echo '<div class="item-collapse-label">';
                echo '<div class="collapse-icons">';
                echo '<span class="collapse-icon collapse-icon-up"></span>';
                echo '<span class="collapse-icon collapse-icon-down"></span>';
                echo '</div>';
                echo esc_html($feature_label) . '</div>';
            }
            echo '<div class="item-collapse-details">'; // Chi tiết sẽ được ẩn bằng CSS
            if (!empty($demo_video) && is_array($demo_video)) {
                $video_url = $demo_video['url']; // Lấy URL của file video
                echo '<div class="demo-video-wrapper">';
                echo '<video controls>';
                echo '<source src="' . esc_url($video_url) . '" type="video/mp4">';
                echo 'Your browser does not support the video tag.';
                echo '</video>';
                echo '</div>';
            }
            if (!empty($feature_description)) {
                echo '<p><strong>Description:</strong> ' . esc_html($feature_description) . '</p>';
            }

            //code demo
            if (!empty($code_snippet)) {

                
                echo '<div class="item-collapse-label">';
                echo '<div class="collapse-icons">';
                echo '<span class="collapse-icon collapse-icon-up"></span>';
                echo '<span class="collapse-icon collapse-icon-down"></span>';
                echo '</div>';
                echo 'Code Demo</div>';

                echo '<div class="item-collapse-details">';
                
                if (!empty($code_snippet)) {
                    echo '<pre><code class="language-php">' . esc_html($code_snippet) . '</code></pre>';
                }
                if (!empty($code_explain)) {
                    echo '<p><strong>Code Explanation:</strong> ' . esc_html($code_explain) . '</p>';
                }
            
                echo '</div>';
            }

            echo '</div>'; // Đóng item-collapse-details
            echo '</div>'; // Đóng feature-item
        endwhile;
    else:
        echo '<p>This feature is empty now</p>'; // Hiển thị thông báo nếu không có dữ liệu
    endif;
    ?>












<?php
//--------Support name for language => subfix

function add_language_meta_box() {
    add_meta_box(
        'page_language',           // ID của box
        'Page Language',           // Tiêu đề của box
        'display_language_meta_box', // Callback function để hiển thị nội dung
        'page',                    // Các post type áp dụng
        'side',                    // Vị trí (bên phải)
        'default'                  // Mức độ ưu tiên
    );
}
add_action( 'add_meta_boxes', 'add_language_meta_box' );


function add_language_info_to_menu_item($item_id, $item, $depth, $args) {
    // Lấy ngôn ngữ từ custom field của menu item (nếu có)
    $language = get_post_meta( $item->object_id, '_page_language', true ); 
    
    // Kiểm tra xem có ngôn ngữ không và hiển thị thông tin
    if ($language) {
        $language_label = ($language == 'vi') ? 'Tiếng Việt' : 'English';
        echo '<div style="margin-top: 5px; color: #0073aa;">Language: ' . $language_label . '</div>';
    }
}
add_action('wp_nav_menu_item_custom_fields', 'add_language_info_to_menu_item', 10, 4);


function display_language_meta_box( $post ) {
    $language = get_post_meta( $post->ID, '_page_language', true );  // Lấy giá trị custom field nếu có
    ?>
    <label for="page_language">Select Language:</label>
    <select name="page_language" id="page_language">
        <option value="vi" <?php selected( $language, 'vi' ); ?>>Tiếng Việt</option>
        <option value="en" <?php selected( $language, 'en' ); ?>>English</option>
    </select>
    <?php
}

function save_language_meta_box( $post_id ) {
    // Kiểm tra nếu đây là một save request hợp lệ
    if ( isset( $_POST['page_language'] ) ) {
        update_post_meta( $post_id, '_page_language', sanitize_text_field( $_POST['page_language'] ) );
    }
}
add_action( 'save_post', 'save_language_meta_box' );


function show_language_on_page_edit() {
    // Lấy ngôn ngữ từ custom field
    global $post;
    $language = get_post_meta( $post->ID, '_page_language', true );
    
    // Hiển thị thông tin ngôn ngữ trong box
    echo '<div><strong>Language:</strong> ';
    echo $language == 'vi' ? 'Tiếng Việt' : 'English';
    echo '</div>';
}
add_action( 'edit_form_after_title', 'show_language_on_page_edit' );
//--------Support name for language => subfix!!!
?>