<?php
if(get_field('usar_este_recurso_como_url'))
{
    header('Location: /', true, 301);
    exit;
}
?>
<?php get_header(); ?>
<?php if (have_posts()):while (have_posts()):the_post(); ?>
<section class="py-5">
    <div class="container">
        <!-- Breadcrumb -->
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%233377FF'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb border-bottom" class="breadcrumb-biblioteca">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo home_url() ?>">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?php echo home_url('/recursos-isil/'); ?>">Recursos ISIL</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php echo get_the_title() ?>
                </li>
            </ol>
        </nav>

        <!-- Contenido del Blog -->
        <div class="row">
            <div class="col-12">
                <article>
                    <h1 class="mb-4 text-black text-center">
                        <?php echo get_the_title() ?>
                    </h1>

                    <div class="recursos-detalles">
                        <div class="mb-3 text-muted fecha-recurso-biblioteca">
                            <strong>Fecha de publicación:</strong>
                            <span class="fst-italic"><?php echo get_the_date(); ?></span>
                        </div>

                        <!-- Categorías -->
                        <?php
                        $categorias = get_the_terms(get_the_ID(), 'categorias_recursos');

                        if ($categorias && !is_wp_error($categorias)) :
                            ?>
                            <div class="mb-4 recurso-biblioteca-categoria">
                                <strong>Categorías: </strong>
                                <?php foreach ($categorias as $categoria) : ?>
                                    <a href="<?php /*echo esc_url(get_term_link($categoria));*/ ?>" class="badge bg-primary text-decoration-none">
                                        <?php echo esc_html($categoria->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    </div>

                    <?php
                        $url_imagen = "https://i.imgur.com/DW9qI2X.gif";
                        $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                        if($thumbnail_url)
                        {
                            $url_imagen = $thumbnail_url;
                        }
                    ?>
                    <!-- Imagen de cabecera -->
                    <span class="imagen-destacada-recursos">
                        <img src="<?php echo $url_imagen ?>" class="img-fluid rounded mb-4" alt="Imagen del blog">
                    </span>

                    <!-- Contenido del artículo -->
                    <div class="detalle-de-recursos">
                        <?php echo get_the_content() ?>
                    </div>

                    <!-- Etiquetas -->
                    <?php
                    $etiquetas = get_the_terms(get_the_ID(), 'etiquetas_recursos');

                    if ($etiquetas && !is_wp_error($etiquetas)) :
                        ?>
                        <div class="detalle-de-etiquetas mt-4">
                            <strong>Etiquetas: </strong>
                            <?php foreach ($etiquetas as $etiqueta) : ?>
                                <a href="<?php /*echo esc_url(get_term_link($etiqueta));*/ ?>" class="badge bg-secondary text-decoration-none">
                                    <?php echo esc_html($etiqueta->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>


                </article>
            </div>
        </div>
    </div>
</section>
<?php endwhile;
            else: ?>
    <p class="py-5 text-center"><?php esc_html_e('No se encontró este contenido', 'ISIL_recursos'); ?></p>
<?php endif; ?>


<?php get_footer(); ?>