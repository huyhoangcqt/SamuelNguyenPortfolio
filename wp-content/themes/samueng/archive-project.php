<?php get_header(); ?>

<main class="project-archive">

    <header class="archive-header">
        <h1 class="archive-title">All Projects</h1>
        <div class="project-controls">
            <input type="text" id="search-project" placeholder="Search projects by name..." />
            <select id="filter-rating">
                <option value="">Filter by rating</option>
                <option value="5">Rating >= 5</option>
                <option value="7">Rating >= 7</option>
                <option value="9">Rating >= 9</option>
            </select>
            <select id="sort-project">
                <option value="start_time_asc">Sort by Start Time (Ascending)</option>
                <option value="start_time_desc">Sort by Start Time (Descending)</option>
                <option value="rating_desc">Sort by Rating (Descending)</option>
                <option value="rating_asc">Sort by Rating (Ascending)</option>
            </select>
            <button id="apply-filters">Apply</button>
        </div>
    </header>

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
            echo '<div class="projects-container">';
            while ($all_projects->have_posts()) : $all_projects->the_post();
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
            echo '</div>'; // Kết thúc container
        else :
            echo "<p>Không có dự án nào.</p>";
        endif;

        wp_reset_postdata();
        ?>
    </div>
    


</main>

<?php get_footer(); ?>
