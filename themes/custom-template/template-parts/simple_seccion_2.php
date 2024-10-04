<?php
$variables_path = get_template_directory() . '/template-parts/_variables_seccion.php';
include($variables_path);
if($opciones_de_seccion['ocultar_contenido']) return;
?>
<!-- SECCION SIMPLE 2 -->
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
        <div class="row align-items-stretch">
            <div class="col-lg-6">
                <div
                    class="d-flex flex-lg-row flex-column justify-content-between align-items-center text-lg-start text-center row-gap-3">
                    <?php if($contenido['imagen']): ?>
                    <img src="<?php echo $contenido['imagen'] ?>" alt="isil-icono"
                        class="img-fluid me-lg-5 me-0" width="78" height="78">
                    <?php endif ?>
                    <?php if($contenido['titulo']): ?>
                    <h2 class="mx-lg-5 mx-0 h1 mb-lg-0 mb-3"><?php echo $contenido['titulo'] ?></h2>
                    <?php endif ?>
                </div>
            </div>
            <div
                class="col-lg-6 d-flex align-items-center text-lg-start text-center isil-linea-izquierda">
                <?php if($contenido['descripcion']): ?>
                <p class="lead mb-0 mx-lg-5 mx-0 fw-normal">
                    <?php echo remove_paragraph_tags($contenido['descripcion']) ?>
                </p>
                <?php endif ?>
            </div>
        </div>
    </div>
</section>
<!-- SECCION SIMPLE 2 -->