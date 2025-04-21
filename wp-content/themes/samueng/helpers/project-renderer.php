<?php
// filepath: c:\xampp\htdocs\samuelPortfolioProj\wp-content\themes\kubio-custom-theme\helpers\project-renderer.php

require_once get_stylesheet_directory() . '/components/collapse/collapse.php';

class ProjectRenderer {
    private $collapse_renderer;

    public function __construct($collapse_renderer) {
        $this->collapse_renderer = $collapse_renderer;
        add_action('wp_enqueue_scripts', [$this, 'enqueue_project_styles']);
    }


    function enqueue_project_styles() {
        if (wp_is_mobile()) {
            // Log kiểm tra xem có vào nhánh mobile không
            error_log('Mobile template detected. Enqueuing mobile CSS.');
        
            // Enqueue CSS cho mobile
            wp_enqueue_style(
                'project-mobile-style',
                get_stylesheet_directory_uri() . '/css/mobile/single-project-mobile.css',
                array(),
                filemtime(get_template_directory() . '/style.css') // Thêm timestamp
            );
        } 
        else {
            // Enqueue CSS cho desktop
            wp_enqueue_style(
                'project-desktop-style',
                get_stylesheet_directory_uri() . '/css/desktop/single-project-desktop.css',
                array(),
                filemtime(get_template_directory() . '/style.css') // Thêm timestamp
            );
        }
    }
    

    public function get_feature_label() {
        $feature_label = get_sub_field('feature_label');
        if (!empty($feature_label)) {
            return esc_html($feature_label);
        }
        return '';
    }

    public function get_feature_detail() {
        $demo_video = get_sub_field('demo_video');
        $feature_description = get_sub_field('feature_description');
        $code_snippet = get_sub_field('code_snippet');
        $code_explain = get_sub_field('code_explain');
        $youtube_video_url = get_sub_field('demo_video_url');

        ob_start();

        // Hiển thị video (embed hoặc demo)
        if (!empty($youtube_video_url)) {
            echo '<div class="demo-video-wrapper demo-video-url-wrapper">'; // Sử dụng cùng class để đồng bộ style
            echo wp_oembed_get($youtube_video_url, array('width' => 786, 'height' => 526)); // Tạo mã nhúng từ URL
            echo '</div>';
        }
        elseif (!empty($demo_video) && is_array($demo_video)) {
            // Hiển thị video demo
            $video_url = $demo_video['url'];
            echo '<div class="demo-video-wrapper">';
            echo '<video controls>';
            echo '<source src="' . esc_url($video_url) . '" type="video/mp4">';
            echo 'Your browser does not support the video tag.';
            echo '</video>';
            echo '</div>';
        }

        // Hiển thị mô tả
        if (!empty($feature_description)) {
            echo '<p><h3>Description:</h3> ' . $feature_description . '</p>';
        }

        echo $this->render_code_block($code_snippet, $code_explain);

        return ob_get_clean();
    }

    public function render_code_block($code_snippet, $code_explain) {
        if (!empty($code_snippet)) {
            return $this->collapse_renderer->render("Code Demo", $this->render_code_block_child($code_snippet, $code_explain));
        }
        return '';
    }

    private function render_code_block_child($code_snippet, $code_explain) {
        ob_start();

        echo format_code_lang($code_snippet, 'php');
        if (!empty($code_explain)) {
            echo '<p><strong>Code Explanation:</strong> ' . ($code_explain) . '</p>';
        }

        return ob_get_clean();
    }

    public function render_feature($feature_name) {
        if (have_rows($feature_name)) {
            ob_start();

            while (have_rows($feature_name)) {
                the_row();

                $feature_label = $this->get_feature_label();
                $feature_detail = $this->get_feature_detail();

                if (empty($feature_label)) {
                    return '';
                }

                // Render collapse component
                echo $this->collapse_renderer->render($feature_label, $feature_detail);
            }

            return ob_get_clean();
        }
        return '';
    }
}