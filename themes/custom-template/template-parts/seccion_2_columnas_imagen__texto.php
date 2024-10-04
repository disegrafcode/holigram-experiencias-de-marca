<?php
$variables_path = get_template_directory() . '/template-parts/_variables_seccion.php';
include($variables_path);
if($opciones_de_seccion['ocultar_contenido']) return;
?>
<!-- SECCIÓN 2 COLUMNAS -->
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
    <div class="<?php echo ($ancho_completo_seccion)?"container-fluid":"container-lg" ?>">
        <div class="row row-gap-3">
            <div class="col-md-6 d-flex align-items-center">
                <div class="text-md-start text-center my-md-4 my-0">
                    <?php if($contenido['titulo']): ?>
                    <div class="h3 text-primary">
                        <?php echo $contenido['titulo'] ?>
                    </div>
                    <?php endif ?>
                    <?php if($contenido['descripcion']): ?>
                    <div class="contenedor-textos-isil">
                        <?php echo $contenido['descripcion'] ?>
                    </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center <?php echo ($contenido['imagen_a_la_derecha'])? "order-first":"" ?>">
                <?php if($contenido['imagen']): ?>
                <img src="<?php echo $contenido['imagen'] ?>" alt="isil-imagen"
                    class="img-fluid">
                <?php endif ?>
            </div>
        </div>
    </div>
</section>
<!-- SECCIÓN 2 COLUMNAS -->