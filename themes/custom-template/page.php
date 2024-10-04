<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <header class="header d-none">
            <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1> <?php edit_post_link(); ?>
        </header>

        <main id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <?php if (has_post_thumbnail()) {
                                the_post_thumbnail('full', array('itemprop' => 'image'));
                            } ?>
                            <?php the_content(); ?>
                            <div class="entry-links"><?php wp_link_pages(); ?></div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <?php if (comments_open() && !post_password_required()) {
            comments_template('', true);
        } ?>
<?php endwhile;
endif; ?>
<?php get_footer(); ?>