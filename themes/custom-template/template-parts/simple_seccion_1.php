<?php
$variables_path = get_template_directory() . '/template-parts/_variables_seccion.php';
include($variables_path);
if($opciones_de_seccion['ocultar_contenido']) return;
?>

<!-- SECCION SIMPLE 1 -->
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
        <div class="row justify-content-center">
            <div class="<?php echo ($ancho_completo_seccion)?"col-md-12":"col-md-8" ?> text-center">
                <h3 style="color: <?php echo $contenido['color_del_titulo'] ?>">
                <?php echo $contenido['titulo'] ?>
                </h3>
                <div class="lead m-0 contenedor-textos-isil" style="color: <?php echo $contenido['color_de_la_descripcion'] ?>">
                    <?php echo $contenido['descripcion'] ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- SECCION SIMPLE 1 -->