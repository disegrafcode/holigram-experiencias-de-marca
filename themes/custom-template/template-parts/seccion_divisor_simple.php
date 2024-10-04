<?php
$variables_path = get_template_directory() . '/template-parts/_variables_seccion.php';
include($variables_path);
if($opciones_de_seccion['ocultar_contenido']) return;
?>

<!-- SECCION DIVISOR SIMPLE-->
<section class="<?php echo $inicial_class ?> <?php echo $clase_personalizada ?>" id="<?php echo $section_id ?>"
    data-template="<?php echo $template_name ?>" <?php echo $style ?>>
    <!-- IMAGEN DE FONDO -->
    <?php if ($imagen_de_fondo_desktop or $imagen_de_fondo_mobile): ?>
        <div class="section_background">
            <div class="desktop_background" style="background-image:url('<?php echo $imagen_de_fondo_desktop ?>')"></div>
            <div class="mobile_background" style="background-image:url('<?php echo $imagen_de_fondo_mobile ?>')"></div>
        </div>
    <?php endif ?>
    <!-- IMAGEN DE FONDO -->
    <div class="<?php echo ($ancho_completo_seccion) ? "container-fluid" : "container" ?>">
        <div class="custom-divider-v2" style="background-image: url(<?php echo $contenido['imagen_de_fondo_del_divisor'] ?>);background-color:<?php echo $contenido['color_de_fondo'] ?>">
            <!-- icono -->
            <?php if($contenido['icono']): ?>
            <span>
                <img src="<?php echo $contenido['icono'] ?>" alt="icon-divider">
            </span>
            <?php endif ?>
            <!-- icono -->

            <!-- titulo -->
            <?php if($contenido['titulo']): ?>
            <p style="color:<?php echo $contenido['color_de_texto'] ?>"><?php echo $contenido['titulo'] ?></p>
            <?php endif ?>
            <!-- titulo -->

        </div>
    </div>
</section>
<!-- SECCION DIVISOR SIMPLE-->