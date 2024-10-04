<?php
$variables_path = get_template_directory() . '/template-parts/_variables_seccion.php';
include($variables_path);
if($opciones_de_seccion['ocultar_contenido']) return;

$config_agenda = $contenido['configuracion_de_agenda'];
 
$cant_items = ($config_agenda['cantidad_items_por_pagina'])?$config_agenda['cantidad_items_por_pagina']:"3";

$cant_columnas = ($config_agenda['columnas'])?$config_agenda['columnas'] : "12"; //bootstrap

$ocultar_buscador = ($config_agenda['ocultar_buscador'])?"display:none;":"";

$ocultar_filtro_cat = ($config_agenda['ocultar_filtro_de_categorias'])?"display:none;":"";

$ocultar_filtro_etiquetas = ($config_agenda['ocultar_filtro_de_etiquetas'])?"display:none;":"";

$ocultar_sidebar = "";

if($config_agenda['ocultar_buscador'] && $config_agenda['ocultar_filtro_de_categorias'] && $config_agenda['ocultar_filtro_de_etiquetas'])
{
    $ocultar_sidebar = "display:none;";
}

// Obtener valores de los filtros y búsqueda desde los parámetros GET
$search_query = isset($_GET['buscar']) ? sanitize_text_field($_GET['buscar']) : '';
$categoria_filter = isset($_GET['categoria']) ? sanitize_text_field($_GET['categoria']) : '';
$etiqueta_filter = isset($_GET['etiqueta']) ? sanitize_text_field($_GET['etiqueta']) : '';
$paged = isset($_GET['pagina']) ? absint($_GET['pagina']) : 1;

// Argumentos de la consulta para los custom posts 'agenda'
$args = [
    'post_type' => 'agenda',
    'posts_per_page' => $cant_items,
    'paged' => $paged,
    's' => $search_query,
    'tax_query' => [
        'relation' => 'AND',
    ],
];

// Agregar filtros a la consulta si existen
if ($categoria_filter) {
    $args['tax_query'][] = [
        'taxonomy' => 'categoria_agenda',
        'field' => 'slug',
        'terms' => $categoria_filter,
    ];
}

if ($etiqueta_filter) {
    $args['tax_query'][] = [
        'taxonomy' => 'etiqueta_agenda',
        'field' => 'slug',
        'terms' => $etiqueta_filter,
    ];
}

// Ejecutar la consulta
$query = new WP_Query($args);
?>

<!-- SECCION AGENDA -->
<section class="<?php echo $inicial_class ?> <?php echo $clase_personalizada ?>" id="<?php echo $section_id ?>"
    data-template="<?php echo $template_name ?>" <?php echo $style ?>>
    <!-- IMAGEN DE FONDO -->
    <?php if($imagen_de_fondo_desktop or $imagen_de_fondo_mobile): ?>
    <div class="section_background">
        <div class="desktop_background" style="background-image:url('<?php echo $imagen_de_fondo_desktop ?>')"></div>
        <div class="mobile_background" style="background-image:url('<?php echo $imagen_de_fondo_mobile ?>')"></div>
    </div>
    <?php endif ?>
    <!-- IMAGEN DE FONDO -->
    <div class="<?php echo ($ancho_completo_seccion)?"container-fluid":"container" ?>">
        <div class="row">
            <div class="col">
            <?php if ($query->have_posts()) : ?>
            <div class="agenda-listas row">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="item-recurso col-lg-<?php echo $cant_columnas ?> mb-4">
                    <div class="agenda-item">
                        <div class="card">
                            <span class="date-agenda">                            
                                <?php echo get_the_date(); ?>
                            </span>
                            <?php
                                $url_imagen = "https://i.imgur.com/RtqPkvv.gif";
                                $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                                if($thumbnail_url)
                                {
                                    $url_imagen = $thumbnail_url;
                                }
                            ?>
                            <img src="<?php echo $url_imagen ?>" class="card-img-top" alt="image-agenda">
                            <div class="card-body">
                                <div class="card-text-container">
                                    <?php
                                        $datos = get_field("datos", get_the_ID());
                                    ?>
                                    <?php if($datos): ?>
                                    <div class="datos-adicionales-biblioteca">
                                        <ul>
                                            <?php foreach($datos AS $dat): ?>
                                            <li>
                                                <?php echo ($dat["icono"])?'<img src="'.$dat["icono"].'" alt="icono">':'' ?>
                                                <span><?php echo $dat["texto"] ?></span>
                                            </li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                    <?php endif ?>
                                    <h5 class="card-title">
                                        <?php echo get_the_title() ?>
                                    </h5>
                                    <div class="card-text">
                                        <?php echo get_the_excerpt() ?>                                
                                    </div>
                                </div>

                                <div class="card-body-button-container">
                                    <?php if(get_field('usar_esta_agenda_como_url', get_the_ID())): ?>
                                        <a href="<?php echo get_field('url_de_la_agenda', get_the_ID()) ?>" class="btn btn-isil-v1 btn-primary">
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
                </div>
                <?php endwhile; ?>
            </div>

            <!-- Paginación -->
            <?php
                $total_pages = $query->max_num_pages;

                if ($total_pages > 1) {
                    echo '<nav class="pagination isil-pagination">';
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
            <p>No se encontraron eventos en la agenda.</p>
            <?php endif; ?>

            <?php wp_reset_postdata(); ?>
            </div>
            <div class="col-md-4" style="<?php echo $ocultar_sidebar ?>">
                <!-- Formulario de búsqueda y filtros -->
                <form method="GET" action="<?php echo get_permalink() ?>" id="filters-form">
                    <div class="buscador-input-biblioteca">
                       <input type="text" name="buscar" value="<?php echo esc_attr($search_query); ?>" placeholder="Buscar..."
                        oninput="this.form.submit()"> 
                    </div>
                    
                    <div class="filter-list filtro-categoria-biblioteca mb-4" style="<?php echo $ocultar_filtro_cat ?>">
                        <h5 class="isil-biblioteca-linea-inicio text-dark mb-3">Categorías</h5>
                        <ul>
                            <li>
                                <input type="radio" name="categoria" value="" <?php checked($categoria_filter, '', true); ?>
                                    onchange="this.form.submit()" id="todas-las-categorias"><label for="todas-las-categorias">Todas las categorias</label>
                            </li>
                            <?php
                            $categorias = get_terms(['taxonomy' => 'categoria_agenda', 'hide_empty' => false]);
                            foreach ($categorias as $categoria) {
                                echo '<li><input type="radio" name="categoria" value="' . esc_attr($categoria->slug) . '" ' . checked($categoria_filter, $categoria->slug, false) . ' onchange="this.form.submit()" id="categoria_' . esc_attr($categoria->slug) . '"><label for="categoria_' . esc_attr($categoria->slug) . '">' . esc_html($categoria->name) . '</label></li>';
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="filter-list filtro-etiquetas-biblioteca mb-3" style="<?php echo $ocultar_filtro_etiquetas ?>">
                        <h5 class="isil-biblioteca-linea-inicio text-dark mb-2">Etiquetas</h5>
                        <ul>
                            <li>
                                <input type="radio" name="etiqueta" value="" <?php checked($etiqueta_filter, '', true); ?>
                                    onchange="this.form.submit()" id="todas-las-etiquetas"><label for="todas-las-etiquetas">Todos</label> 
                            </li>
                            <?php
                            $etiquetas = get_terms(['taxonomy' => 'etiqueta_agenda', 'hide_empty' => false]);
                            foreach ($etiquetas as $etiqueta) {
                                echo '<li><input type="radio" name="etiqueta" value="' . esc_attr($etiqueta->slug) . '" ' . checked($etiqueta_filter, $etiqueta->slug, false) . ' onchange="this.form.submit()" id="etiqueta_' . esc_attr($etiqueta->slug) . '"><label for="etiqueta_' . esc_attr($etiqueta->slug) . '">' . esc_html($etiqueta->name) . '</label></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- SECCION AGENDA -->