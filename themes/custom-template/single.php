<?php get_header(); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('card mb-4'); ?>>
                        <div class="card-body">
                            <?php get_template_part('entry'); ?>
                            <?php if (comments_open() && !post_password_required()) {
                                comments_template('', true);
                            } ?>
                        </div>
                    </article>
                <?php endwhile;
            else : ?>
                <p><?php esc_html_e('Sorry, no posts matched your criteria.', 'text_domain'); ?></p>
            <?php endif; ?>
        </div>
        <?php if (is_active_sidebar('sidebar-1')) : ?>
            <div class="col-md-4">
                <?php get_sidebar(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<footer class="footer">
    <?php get_template_part('nav', 'below-single'); ?>
</footer>
<?php get_footer(); ?>
