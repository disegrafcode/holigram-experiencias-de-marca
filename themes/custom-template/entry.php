<article id="post-<?php the_ID(); ?>" <?php post_class('card mb-4'); ?>>
    <div class="card-body">
        <header class="card-header">
            <?php if (is_singular()) {
                echo '<h1 class="card-title entry-title" itemprop="headline">';
            } else {
                echo '<h2 class="card-title entry-title">';
            } ?>
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
            <?php if (is_singular()) {
                echo '</h1>';
            } else {
                echo '</h2>';
            } ?>
            <?php edit_post_link('<span class="edit-link">', '</span>'); ?>
            <?php if (!is_search()) {
                get_template_part('entry', 'meta');
            } ?>
        </header>
        <div class="card-text">
            <?php get_template_part('entry', (is_front_page() || is_home() || is_front_page() && is_home() || is_archive() || is_search() ? 'summary' : 'content')); ?>
        </div>
        <?php if (is_singular()) {
            get_template_part('entry-footer');
        } ?>
    </div>
</article>