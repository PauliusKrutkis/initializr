<?php get_header(); ?>

<div class="container">

    <?php
    while (have_posts()) {
        the_post();
        get_template_part('/partials/article');
    }
    ?>

</div>

<?php get_footer(); ?>
