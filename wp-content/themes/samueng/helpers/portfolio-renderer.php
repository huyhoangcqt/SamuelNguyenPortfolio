<?php
// filepath: c:\xampp\htdocs\samuelPortfolioProj\wp-content\themes\kubio-custom-theme\helpers\portfolio-renderer.php

class PortfolioRenderer 
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_portfolio_styles']);
    }

    function enqueue_portfolio_styles() {
        wp_enqueue_style(
            'portfolio-mobile-style',
            get_stylesheet_directory_uri() . '/css/page-portfolio.css',
            array(),
            filemtime(get_template_directory() . '/style.css') // Thêm timestamp
        );
    }
    
    public function render_projects_by_year() {
        $all_projects = new WP_Query(array(
            'post_type'      => 'project',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'meta_query'     => array(
                array(
                    'key'     => 'rating',  // Trường custom field "rating"
                    'value'   => 2,        // Giá trị tối thiểu
                    'compare' => '>=',     // Lấy các bài viết có rating >= 2
                    'type'    => 'NUMERIC' // Kiểu dữ liệu là số
                )
            ),
            'orderby'        => 'meta_value', // Sắp xếp theo custom field
            'meta_key'       => 'project_start', // Trường custom field "start_time"
            'order'          => 'ASC'        // Sắp xếp tăng dần theo thời gian bắt đầu
        ));

        if ($all_projects->have_posts()) {
            $projects_by_year = array();

            // Nhóm bài viết theo năm
            while ($all_projects->have_posts()) {
                $all_projects->the_post();
                $project_start = get_post_meta(get_the_ID(), 'project_start', true);
                $year = date('Y', strtotime($project_start)); // Lấy năm từ project_start

                if (!isset($projects_by_year[$year])) {
                    $projects_by_year[$year] = array();
                }

                $projects_by_year[$year][] = array(
                    'title'     => get_the_title(),
                    'permalink' => get_permalink(),
                    'rating'    => get_post_meta(get_the_ID(), 'rating', true),
                    'thumbnail' => has_post_thumbnail() ? get_the_post_thumbnail(get_the_ID(), 'medium') : '',
                    'excerpt'   => get_the_excerpt(),
                    'project'   => get_post(get_the_ID()) // Lấy đối tượng bài viết đầy đủ
                );
            }

            wp_reset_postdata();

            // Render HTML
            return $this->render_projects_html($projects_by_year);
        } else {
            return "<p>Không có dự án nào.</p>";
        }
    }

    private function render_projects_html($projects_by_year) {
        ob_start();
    
        echo '<div class="projects-container">';
        foreach ($projects_by_year as $year => $projects) {
            echo '<div class="project-row">';
            // Cột bên trái: Năm
            echo "<div class='project-year'><h2 class='project-year-label'>$year</h2></div>";
    
            // Cột bên phải: Thông tin dự án
            echo "<div class='project-details'>";
            foreach ($projects as $project) {
                echo "<article class='project-item'>";
                echo $this->render_project_layout_showcase($project['project']); // Gọi hàm render_project_layout_showcase
                echo "</article>";
            }
            echo "</div>"; // Kết thúc cột bên phải
            echo "</div>"; // Kết thúc hàng
        }
        echo '</div>'; // Kết thúc container
    
        return ob_get_clean();
    }

    public function render_project_layout_showcase($project) {
        ob_start();

        // Lấy thông tin từ $project
        $youtube_video_url = get_post_meta($project->ID, 'teaser_trailer', true);
        $banner_image = get_field('banner_image', $project->ID);
        $time_duration = get_field('time_duration', $project->ID);
        $project_type = get_field('project_type', $project->ID);
        $team_size = get_field('team_size', $project->ID);
        $responsibilities = get_field('responsibilites', $project->ID);
        $engine_and_tools = get_field('engine_and_tools', $project->ID);

        ?>
        <div class="project-layout">
            <div class="project-teaser-trailer">
                <?php if (!empty($youtube_video_url)): ?>
                    <div class="video-wrapper">
                        <?php echo wp_oembed_get($youtube_video_url); ?>
                    </div>
                <?php else:
                    if (!empty($banner_image)) {
                        echo '<div class="video-wrapper">';
                        echo '<img src="' . esc_url($banner_image['url']) . '">';
                        echo '</div>';
                    }
                endif; ?>
            </div>

            <div class="project-info">
                <h3 class="project-title-highlight project-title">
                    <a href="<?php echo esc_url(get_permalink($project->ID)); ?>">
                        <?php echo esc_html($project->post_title); ?>
                    </a>
                </h3>
                <p><strong>Project Length:</strong> <?php echo esc_html($time_duration); ?></p>
                <?php if ($project_type == 'personal'): ?>
                    <p><strong>Project Type:</strong> Personal</p>
                <?php else: ?>
                    <p><strong>Project Type:</strong> Team - <strong>Size:</strong> <?php echo esc_html($team_size); ?></p>
                <?php endif; ?>
                <p><strong>Responsibilities:</strong> <?php echo esc_html($responsibilities); ?></p>
                <p><strong>Engine and Tools:</strong> <?php echo esc_html($engine_and_tools); ?></p>
                <p><strong>Languages:</strong> <?php echo get_label_selected_field('programming_languages', $project->ID); ?></p>
            </div>
        </div>
        <?php

        return ob_get_clean();
    }


}