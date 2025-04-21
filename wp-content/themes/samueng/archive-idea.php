<?php get_header(); ?>

<main class="idea-archive">
    <header class="archive-header">
        <h1 class="archive-title">Danh sách Dự Án</h1>
    </header>

    <?php if (have_posts()) : ?>
        <div class="idea-list">
            <?php while (have_posts()) : the_post(); ?>
                <article class="idea-item">
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

    

</main>

<?php get_footer(); ?>
