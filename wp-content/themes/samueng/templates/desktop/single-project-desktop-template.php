<?php get_header(); ?>

<div class="single-project-mobile-body layout-body-center">
    <div id="content" data-kubio="kubio/root">
        <?php the_content(); ?>
    </div>

    <h1 class="project-name"><?php the_title(); ?></h1>    
    <?php
        $start_date = get_field('project_start'); // Lấy giá trị của trường start_date
        if (!empty($start_date)) {
            echo '<p class="project-start-date"><strong>Start:</strong> ' . esc_html($start_date) . '</p>';
        } 
        else {
        }
    ?>
    <?php
        $release_date = get_field('release_date'); // Lấy giá trị của trường release_date
        if (!empty($release_date)) {
            echo '<p class="project-release-date"><strong>Release:</strong> ' . esc_html($release_date) . '</p>';
        } 
        else {
        }
    ?>
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
                echo '<p class="project-platforms"><strong>Platforms:</strong> ' . esc_html(implode(', ', $labels)) . '</p>';
            }
        } 
    ?>

    <div class="project-layout">
        <div class="project-teaser-trailer">
            <?php 
                global $post, $wp_embed;
                $youtube_video_url = get_post_meta($post->ID, 'teaser_trailer', true); //store youtube URL in variable

                if (!empty($youtube_video_url)) {
                    // Nhúng video với chiều rộng full width
                    echo '<div class="media-wrapper">';
                    echo wp_oembed_get($youtube_video_url);
                    echo '</div>';
                } else {
                    // Nếu không có teaser_trailer, kiểm tra video_trailer
                    $video_trailer = get_field('video_trailer'); // Lấy giá trị từ ACF field video_trailer
                    if (!empty($video_trailer)) {
                        echo '<div class="media-wrapper">';
                        echo '<video controls width="100%">';
                        echo '<source src="' . esc_url($video_trailer) . '" type="video/mp4">';
                        echo 'Your browser does not support the video tag.';
                        echo '</video>';
                        echo '</div>';
                    }                     
                    else {
                        $banner_image = get_field('banner_image');
                        if (!empty($banner_image)) {
                            echo '<div class="banner_image media-wrapper">';
                            echo '<img src="' . esc_url($banner_image['url']) .  '">';
                            echo '</div>';
                        }
                    }
                }
            ?>
        </div>

        <div class="project-info">
            <h3>Project Info</h3>

            <p><strong>Project Length:</strong> <?php echo esc_html(get_field('time_duration')); ?></p>
            <?php
            
            $project_type = get_field('project_type');
            if ($project_type == 'personal')
            {
                echo '<p><strong>Project Type:</strong> Personal </p>';
            }
            else
            {
                echo '<p><strong>Project Type:</strong> Team - <strong> Size:</strong>' . esc_html(get_field('team_size')) . '</p>';
                echo '<p><strong>Work At:</strong> ' . esc_html(get_field('company')) . '</p>';
            }
            ?>
            <p><strong>Responsibilities:</strong> <?php echo esc_html(get_field('responsibilites')); ?></p>
            <p><strong>Engine and tools:</strong> <?php echo esc_html(get_field('engine_and_tools')); ?></p>
            <p><strong>Languages:</strong> <?php 
                global $post;
                echo get_label_selected_field('programming_languages', $post->ID); 
            ?></p>
        </div>
    </div>


    <p></p>
    
    <div class="project-description-container">
        <div class="project-field-label">Description:</div>
        <span class="project-description">
            <?php echo get_field('project_descriptions'); ?>
        </span>
    </div>

    <p></p>

    <?php 
        echo '<div class="features-container"><span class="features-label project-field-label">What I Do:</span>';
        echo '<div class="what-i-do">';
        echo get_field('what_i_do');
        echo '</div>';
        echo '</div>';
    ?>
    <?php
        // Hiển thị các feature
        echo '<div class="features-container"><span class="features-label project-field-label">What I Learn:</span>';
        echo '<div class="what-i-learn">';
        echo get_field('what_i_learn');
        echo '</div>';
        echo $project_renderer->render_feature('feature_1');
        echo $project_renderer->render_feature('feature_2');
        echo $project_renderer->render_feature('feature_3');
        echo $project_renderer->render_feature('feature_4');
        echo $project_renderer->render_feature('feature_5');
        echo $project_renderer->render_feature('feature_6');
        echo '</div>';
    ?>
    
</div>


<?php get_footer(); ?>

