<?php
$variables_path = get_template_directory() . '/template-parts/_variables_seccion.php';
include($variables_path);
if($opciones_de_seccion['ocultar_contenido']) return;

$config_recursos = $contenido['configuracion_de_recursos'];
 
$cant_items = ($config_recursos['cantidad_de_items_por_pagina'])?$config_recursos['cantidad_de_items_por_pagina']:"3";

$cant_columnas = ($config_recursos['columnas'])?$config_recursos['columnas'] : "6"; //bootstrap

$ocultar_buscador = ($config_recursos['ocultar_buscador'])?"display:none;":"";

$ocultar_filtro_cat = ($config_recursos['ocultar_filtro_de_categorias'])?"display:none;":"";

$ocultar_filtro_etiquetas = ($config_recursos['ocultar_filtro_de_etiquetas'])?"display:none;":"";

$ocultar_sidebar = "";

if($config_recursos['ocultar_buscador'] && $config_recursos['ocultar_filtro_de_categorias'] && $config_recursos['ocultar_filtro_de_etiquetas'])
{
    $ocultar_sidebar = "display:none;";
}

?>

<?php
// Obtener valores de los filtros y búsqueda desde los parámetros GET
$search_query = isset($_GET['buscar']) ? sanitize_text_field($_GET['buscar']) : '';
$categoria_filter = isset($_GET['categoria']) ? sanitize_text_field($_GET['categoria']) : '';
$etiqueta_filter = isset($_GET['etiqueta']) ? sanitize_text_field($_GET['etiqueta']) : '';
$formato_filter = isset($_GET['formato']) ? sanitize_text_field($_GET['formato']) : '';
$paged = isset($_GET['pagina']) ? absint($_GET['pagina']) : 1;

// Argumentos de la consulta para los custom posts 'recursos'
$args = [
    'post_type' => 'recursos',
    'posts_per_page' => intval($cant_items),
    'paged' => $paged,
    's' => $search_query,
    'tax_query' => [
        'relation' => 'AND',
    ],
];

// Agregar filtros a la consulta si existen
if ($categoria_filter) {
    $args['tax_query'][] = [
        'taxonomy' => 'categorias_recursos',
        'field' => 'slug',
        'terms' => $categoria_filter,
    ];
}

if ($etiqueta_filter) {
    $args['tax_query'][] = [
        'taxonomy' => 'etiquetas_recursos',
        'field' => 'slug',
        'terms' => $etiqueta_filter,
    ];
}

if ($formato_filter) {
    $args['tax_query'][] = [
        'taxonomy' => 'formatos_recursos',
        'field' => 'slug',
        'terms' => $formato_filter,
    ];
}

// Ejecutar la consulta
$query = new WP_Query($args);
?>


<!-- SECCIÓN RECURSOS -->
<section
    class="<?php echo $inicial_class ?> <?php echo $clase_personalizada ?>"
    id="<?php echo $section_id ?>" 
    data-template= "<?php echo $template_name ?>" 
    <?php echo $style ?>
    >
    <!-- IMAGEN DE FONDO -->
    <?php if($imagen_de_fondo_desktop or $imagen_de_fondo_mobile): ?>
        <div class="section_background">
            <div class="desktop_background"
                style="background-image:url('<?php echo $imagen_de_fondo_desktop ?>')"
            ></div>
            <div class="mobile_background"
                style="background-image:url('<?php echo $imagen_de_fondo_mobile ?>')"
            ></div>
        </div>
    <?php endif ?>
    <!-- IMAGEN DE FONDO -->
    <div class="<?php echo ($ancho_completo_seccion)?"container-fluid":"container" ?>">
        <div class="row">
            <div class="col-md-4" style="<?php echo $ocultar_sidebar ?>">
                <!-- Formulario de búsqueda y filtros -->
                <form method="GET" action="<?php echo get_permalink() ?>" id="filters-form" class="mb-4">
                    <div class="buscador-input-biblioteca" style="<?php echo $ocultar_buscador ?>">
                        <input type="text" name="buscar" value="<?php echo esc_attr($search_query); ?>" placeholder="Buscar..." oninput="this.form.submit()">
                    </div>                   

                    <div class="filter-list filtro-categoria-biblioteca mb-4" style="<?php echo $ocultar_filtro_cat ?>">
                        <h5 class="isil-biblioteca-linea-inicio text-dark mb-3">Categorías</h5>
                        <ul>
                            <!-- Opción para borrar el filtro de categorías -->
                            <li>
                                <input type="radio" name="categoria" value="" <?php checked($categoria_filter, ''); ?> onchange="this.form.submit()" id="todas-las-categorias"> 
                                <label for="todas-las-categorias">Todas las categorias</label>
                            </li>
                            <?php
                            $categorias = get_terms(['taxonomy' => 'categorias_recursos', 'hide_empty' => false]);
                            foreach ($categorias as $categoria) {
                                echo '<li><input type="radio" name="categoria" value="' . esc_attr($categoria->slug) . '" ' . checked($categoria_filter, $categoria->slug, false) . ' onchange="this.form.submit()" id="categoria_' . esc_attr($categoria->slug) . '"><label for="categoria_' . esc_attr($categoria->slug) . '">' . esc_html($categoria->name) . '</label></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    
                    <div class="filter-list filtro-etiquetas-biblioteca mb-3" style="<?php echo $ocultar_filtro_etiquetas ?>">
                        <h5 class="isil-biblioteca-linea-inicio text-dark mb-2">Etiquetas</h5>
                        <ul>
                            <!-- Opción para borrar el filtro de etiquetas -->
                            <li>
                                <input type="radio" name="etiqueta" value="" <?php checked($etiqueta_filter, ''); ?> onchange="this.form.submit()" id="todas-las-etiquetas"> 
                                <label for="todas-las-etiquetas">Todos</label>
                            </li>
                            <?php
                            $etiquetas = get_terms(['taxonomy' => 'etiquetas_recursos', 'hide_empty' => false]);
                            foreach ($etiquetas as $etiqueta) {
                                echo '<li><input type="radio" name="etiqueta" value="' . esc_attr($etiqueta->slug) . '" ' . checked($etiqueta_filter, $etiqueta->slug, false) . ' onchange="this.form.submit()" id="etiqueta_' . esc_attr($etiqueta->slug) . '"><label for="etiqueta_' . esc_attr($etiqueta->slug) . '">' . esc_html($etiqueta->name) . '</label></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    
                    <!-- filtro de busqueda por formatos OCULTO -->
                    <select name="formato" onchange="this.form.submit()" style="display:none">
                        <option value="">Todos los Formatos</option>
                        <?php
                        $formatos = get_terms(['taxonomy' => 'formatos_recursos', 'hide_empty' => false]);
                        foreach ($formatos as $formato) {
                            echo '<option value="' . esc_attr($formato->slug) . '" ' . selected($formato_filter, $formato->slug, false) . '>' . esc_html($formato->name) . '</option>';
                        }
                        ?>
                    </select>
                    <!-- filtro de busqueda por formatos OCULTO -->
                </form>
            </div>

            <div class="col">
                <?php if ($query->have_posts()) : ?>
                    <div class="recursos-list row">
                        <?php while ($query->have_posts()) : $query->the_post(); ?>
                            <div class="item-recurso col-lg-<?php echo $cant_columnas ?>">
                                <div class="card mb-4">
                                    <?php
                                        $url_imagen = "https://i.imgur.com/KiwXnmV.gif";
                                        $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                                        if($thumbnail_url)
                                        {
                                            $url_imagen = $thumbnail_url;
                                        }
                                    ?>
                                    <img src="<?php echo $url_imagen ?>" class="card-img-top" alt="imagen-recursos">
                                    <div class="card-body">
                                        <div class="card-text-container">
                                            <span class="small text-date-biblioteca">
                                                <?php echo get_the_date(); ?>
                                            </span>
                                            <h5 class="card-title text-dark">
                                                <?php echo get_the_title() ?>
                                            </h5>
                                            <div class="card-text mb-3">
                                                <?php echo get_the_excerpt() ?>                                
                                            </div>
                                        </div>
                                        <div class="card-body-button-container">
                                            <?php if(get_field('usar_este_recurso_como_url', get_the_ID())): ?>
                                                <a href="<?php echo get_field('url_del_recurso', get_the_ID()) ?>" class="btn btn-isil-v1 btn-primary">
                                                     <?php echo (get_field('texto_para_el_boton', get_the_ID()))?get_field('texto_para_el_boton', get_the_ID()):"ver más detalles" ?>
                                                </a> 
                                            <?php else: ?>
                                                <a href="<?php the_permalink() ?>" class="btn btn-isil-v1 btn-primary">
                                                    <?php echo (get_field('texto_para_el_boton', get_the_ID()))?get_field('texto_para_el_boton', get_the_ID()):"ver más detalles" ?>
                                                </a>   
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>                               
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <!-- Paginación -->
                <?php
                    $total_pages = $query->max_num_pages;

                    if ($total_pages > 1) {
                        echo '<nav class="pagination isil-pagination" style="justify-content: flex-start">';
                        echo paginate_links([
                            'base' => add_query_arg('pagina', '%#%'),
                            'format' => '?pagina=%#%',
                            'current' => $paged,
                            'total' => $total_pages,
                            'prev_text' => __('« Anterior'),
                            'next_text' => __('Siguiente »'),
                        ]);
                        echo '</nav>';
                    }
                    ?>
                <?php else : ?>
                    <p>No se encontraron recursos.</p>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
</section>
<!-- SECCIÓN RECURSOS -->