<?php get_header(); ?>

<?php if (have_posts()): ?>

    <div class="container">
        <?php
        while (have_posts()) {
            the_post();
            the_content();
        }
        get_template_part('partials/sidebar');
        ?>
    </div>

<?php endif; ?>

<?php get_footer(); ?>

