<?php
// filepath: c:\xampp\htdocs\samuelPortfolioProj\wp-content\themes\kubio-custom-theme\page-portfolio.php



get_header();
?>

<main class="portfolio-page layout-body-center">
    <header class="page-header">
        <h1 class="page-title">My Timeline</h1>
    </header>

    <div class="project-timeline">
        <?php
            echo $portfolio_renderer->render_projects_by_year();
        ?>
    </div>
</main>

<?php get_footer(); ?>