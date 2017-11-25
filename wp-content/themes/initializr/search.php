<?php get_header(); ?>

<div class="container">

    <?php if (have_posts()): ?>

        <header class="content-head">
            <h1><?php printf(esc_html__('Search Results for: %s', 'initializr'),
                    '<span>' . get_search_query() . '</span>'); ?></h1>
        </header>

        <?php while (have_posts()): the_post(); ?>

            <?php get_template_part('/partials/article'); ?>

        <?php endwhile; ?>

    <?php else: ?>

        <header class="content-head">
            <h1><?php _e('Nothing Found', 'initializr'); ?></h1>
            <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.',
                    'initializr') ?></p>
        </header>

    <?php endif; ?>

    <?php get_template_part('/partials/sidebar') ?>

</div>

<?php get_footer(); ?>
