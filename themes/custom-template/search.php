<?php get_header(); ?>

<div class="container">
    <?php if (have_posts()) : ?>
        <header class="page-header">
            <h1 class="entry-title" itemprop="name"><?php printf(esc_html__('Search Results for: %s', 'customTemplate'), get_search_query()); ?></h1>
        </header>

        <div class="row">
            <?php while (have_posts()) : the_post(); ?>
                <div class="col-md-4">
                    <?php get_template_part('entry'); ?>
                </div>
            <?php endwhile; ?>
        </div>

        <?php get_template_part('nav', 'below'); ?>
    <?php else : ?>
        <div class="alert alert-secondary mt-4" role="alert">
            <h2><?php esc_html_e('Nothing Found', 'customTemplate'); ?></h2>
            <p><?php esc_html_e('Sorry, nothing matched your search. Please try again.', 'customTemplate'); ?></p>
            <?php get_search_form(); ?>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
