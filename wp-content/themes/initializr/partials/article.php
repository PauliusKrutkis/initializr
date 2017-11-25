<article class="article" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="article__header">
        <h2>
            <a rel="bookmark" href="<?php echo esc_url(get_permalink()) ?>"><?php the_title() ?></a>
        </h2>
        <time datetime="<?php the_time('Y-m-d'); ?>">
            <?php echo the_time('Y-m-d') ?>
        </time>
    </header>
    <div class="article__content">
        <?php the_excerpt(); ?>
    </div>
</article>
