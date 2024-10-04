<?php
/*
Template Name: ISIL Template Base
*/
get_header();
$default_template_parts = get_template_directory() . '/template-parts/default_seccion.php';
$contenidos = get_field("contenidos");
?>
    <?php if (have_posts()): ?>
        <?php while (have_posts()):
            the_post() ?>
            <?php
            if ($contenidos) {
                foreach ($contenidos as $key => $contenido):
                    $file_path = get_template_directory() . '/template-parts/' . $contenido['acf_fc_layout'] . '.php';
                    if (file_exists($file_path)):
                        include $file_path;
                    else:
                        include $default_template_parts;
                    endif;
                endforeach;
            }
            ?>
            <?php /*if(is_user_logged_in()):  echo "<pre>" . dd($contenidos) . "</pre>";  endif */?>
        <?php endwhile ?>
    <?php endif ?>
    
<?php get_footer(); ?>