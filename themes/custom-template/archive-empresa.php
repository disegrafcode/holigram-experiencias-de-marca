<?php
/**
 * The template for displaying archive pages for 'empresa' custom post type.
 */
get_header();

// Obtener las opciones configuradas
$archive_title = get_option('empresa_archive_title', __('Empresas', 'ISIL empleabilidad'));
$archive_description = get_option('empresa_archive_description', '');
$posts_per_page = get_option('empresa_archive_posts_per_page', 10);
$archive_image = get_option('empresa_archive_image', '');
?>

<!-- HEADER -->
<section class="py-5 bg-gray" style="background-image:url(<?php echo esc_url($archive_image) ?>)">
    <div class="container">
        <h1 class="text-white text-shadow-1 text-md-start text-center">
            <?php echo $archive_title ?>
        </h1>
    </div>
</section>
<!-- HEADER -->

<!-- BUSCADOR -->
<section class="py-5 bg-light">
    <div class="container">
        <!-- Search form -->
        <form method="GET" action="" class="row row-gap-3">

            <div class="col-md-3">
                <input type="text" name="search" id="search"
                    value="<?php echo isset($_GET['search']) ? esc_attr($_GET['search']) : ''; ?>" class="form-control"
                    placeholder="<?php _e('Buscar...', 'ISIL empleabilidad'); ?>">
            </div>
            <div class="col-md-3">
                <select name="categoria_empresa" id="categoria_empresa" class="form-select">
                    <option value=""><?php _e('Todas las Categorías', 'ISIL empleabilidad'); ?></option>
                    <?php
                        $categories = get_terms(
                            array(
                                'taxonomy' => 'categoria_empresa', // Asegúrate de que esta es la taxonomía correcta para 'empresa'
                                'hide_empty' => false,
                            )
                        );
                        foreach ($categories as $category) {
                            ?>
                    <option value="<?php echo esc_attr($category->slug); ?>"
                        <?php selected(isset($_GET['categoria_empresa']) ? $_GET['categoria_empresa'] : '', $category->slug); ?>>
                        <?php echo esc_html($category->name); ?>
                    </option>
                    <?php
                        }
                        ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="etiqueta_empresa" id="etiqueta_empresa" class="form-select">
                    <option value=""><?php _e('Todas las Etiquetas', 'ISIL empleabilidad'); ?></option>
                    <?php
                        $tags = get_terms(
                            array(
                                'taxonomy' => 'etiqueta_empresa', // Asegúrate de que esta es la taxonomía correcta para 'empresa'
                                'hide_empty' => false,
                            )
                        );
                        foreach ($tags as $tag) {
                            ?>
                    <option value="<?php echo esc_attr($tag->slug); ?>"
                        <?php selected(isset($_GET['etiqueta_empresa']) ? $_GET['etiqueta_empresa'] : '', $tag->slug); ?>>
                        <?php echo esc_html($tag->name); ?>
                    </option>
                    <?php
                        }
                        ?>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit"
                    class="btn btn-primary w-100"><?php _e('Filtrar', 'ISIL empleabilidad'); ?></button>
            </div>
        </form>
    </div>
</section>
<!-- BUSCADOR -->

<!-- EMPRESAS -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                // Define the custom query parameters
                @$paged = ($_GET['pag']) ? $_GET['pag'] : 1;
                $search_query = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
                $category = isset($_GET['categoria_empresa']) ? sanitize_text_field($_GET['categoria_empresa']) : '';
                $tag = isset($_GET['etiqueta_empresa']) ? sanitize_text_field($_GET['etiqueta_empresa']) : '';

                $args = array(
                    'post_type' => 'empresa',
                    'posts_per_page' => $posts_per_page,
                    'paged' => $paged,
                    's' => $search_query,
                );

                if ($category) {
                    $args['tax_query'][] = array(
                        'taxonomy' => 'categoria_empresa',
                        'field' => 'slug',
                        'terms' => $category,
                    );
                }

                if ($tag) {
                    $args['tax_query'][] = array(
                        'taxonomy' => 'etiqueta_empresa',
                        'field' => 'slug',
                        'terms' => $tag,
                    );
                }

                // Instantiate the custom query
                $custom_query = new WP_Query($args);

                // Pagination fix
                $temp_query = $wp_query;
                $wp_query = NULL;
                $wp_query = $custom_query;

                // Output custom query loop
                if ($custom_query->have_posts()):
                    while ($custom_query->have_posts()):

                        $custom_query->the_post();

                        $featured_image_id = get_post_thumbnail_id(get_the_ID());
                        $original_image = wp_get_attachment_image_src($featured_image_id, 'full'); 
                        $image_url = "http://empleabilidad.isil.pe/wp-content/uploads/2024/06/cropped-icono-isil.jpg";
                        if ($original_image) {
                            $image_url = $original_image[0];
                        }
                        $pais = get_post_meta( get_the_ID(), 'empresa-pais', true );
                        $departamento = get_post_meta( get_the_ID(), 'empresa-departamento', true );  
                        ?>

                <div class="border-bottom py-4">
                    <div class="d-flex justify-content-md-start justify-content-center gap-3">
                        <span>
                            <img src="<?php echo esc_url($image_url) ?>" alt="imagen" width="90">
                        </span>

                        <div class="position-relative">
                            <!-- <span class="position-absolute top-0 end-0">0 empleos disponibles</span> -->
                            <h5 class="text-md-start text-center">
                                <?php echo get_the_title(); ?>
                            </h5>
                            <?php if($pais && $departamento): ?>
                            <ul class="list-unstyled">
                                <li>
                                    <img src="http://empleabilidad.isil.pe/wp-content/uploads/2024/07/mark-ic.png"
                                        alt="icon" width="16">
                                    <?php echo "$pais, $departamento" ?>
                                </li>
                            </ul>
                            <?php endif ?>
                            <p>
                                <?php echo get_the_excerpt(); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <?php endwhile ?>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    <?php
                    $pagination_links = paginate_links(
                        array(
                            'total'        => $custom_query->max_num_pages,
                            'current'      => $paged,
                            'format'       => '?pag=%#%',
                            'show_all'     => false,
                            'type'         => 'array', // Importante: cambiar a 'array' para personalizar el HTML
                            'prev_next'    => true,
                            'prev_text'    => __('« Prev'),
                            'next_text'    => __('Next »'),
                            'add_args'     => array(
                                'search'             => $search_query,
                                'categoria_empresa'  => $category,
                                'etiqueta_empresa'   => $tag,
                            ),
                            'add_fragment' => '',
                        )
                    );

                    if ($pagination_links && is_array($pagination_links)) {
                        echo '<ul class="pagination">';
                        foreach ($pagination_links as $link) {
                            $active_class = strpos($link, 'current') !== false ? 'active' : '';
                            echo '<li class="page-item ' . $active_class . '">' . str_replace('page-numbers', 'page-link', $link) . '</li>';
                        }
                        echo '</ul>';
                    }
                    ?>
                </div>


                <?php
                else:
                    echo '<p>' . __('No se encontraron resultados.', 'ISIL empleabilidad') . '</p>';
                endif;

                // Reset postdata
                wp_reset_postdata();

                // Reset main query object
                $wp_query = NULL;
                $wp_query = $temp_query;
                ?>
            </div>
        </div>
    </div>
</section>
<!-- EMPRESAS -->

<?php get_footer(); ?>