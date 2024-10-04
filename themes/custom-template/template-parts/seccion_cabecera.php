<?php
$variables_path = get_template_directory() . '/template-parts/_variables_seccion.php';
include($variables_path);
if($opciones_de_seccion['ocultar_contenido']) return;
?>

<!-- seccion cabecera página -->
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
        <div class="row justify-content-center py-md-4 py-0">
            <h1 class="text-shadow-1 text-center" style="color:<?php echo $contenido['color_de_texto'] ?>">
                <?php echo ($contenido['titulo'])?$contenido['titulo']:the_title() ?>
            </h1>
            <div class="text-center">
                <?php
                if (!is_front_page()) {
                    echo '<nav class="breadcrumb mb-0" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'7\' height=\'7\'%3E%3Ccircle cx=\'3.5\' cy=\'3.5\' r=\'3.5\' fill=\'%23FFD700\'/%3E%3C/svg%3E&#34;);
" aria-label="breadcrumb">';
                    
                    echo '<ol class="breadcrumb d-flex justify-content-center mb-0 w-100">';
                    $home_id = get_option('page_on_front');
                    $home_title = get_the_title($home_id);
                    $ancestors = array_reverse(get_post_ancestors($post->ID));

                    if ($post->post_parent != $home_id && !$ancestors) {
                        echo '<li class="breadcrumb-item small"><a href="'.home_url().'" class="text-decoration-none small" style="color:'.$contenido['color_de_texto'].'">'.$home_title.'</a></li>';
                    }

                    foreach ($ancestors as $ancestor) {
                        echo '<li class="breadcrumb-item small"><a href="'.get_permalink($ancestor).'" class="text-decoration-none small" style="color:'.$contenido['color_de_texto'].'">'.get_the_title($ancestor).'</a> </li>';
                    }

                    echo '<li class="breadcrumb-item active small" style="color:'.$contenido['color_de_texto'].'">'.get_the_title().'</li>';

                    echo '</ol>';
                    echo '</nav>';
                }
                ?>
            </div>
        </div>
    </div>
</section>
<!-- seccion cabecera página -->