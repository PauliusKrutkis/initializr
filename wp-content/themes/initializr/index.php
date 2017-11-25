<?php get_header(); ?>

<div class="container">

    <?php while (have_posts()): the_post(); ?>

        <?php the_content(); ?>

    <?php endwhile; ?>

    <?php get_template_part('partials/sidebar') ?>

</div>

<?php get_footer(); ?>
