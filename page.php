<?php
get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

<?php while (have_posts()) {
    the_post();
?>

<?php get_template_part('content', 'page'); ?>

<?php
}
?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php get_sidebar('page'); ?>
<?php get_footer(); ?>