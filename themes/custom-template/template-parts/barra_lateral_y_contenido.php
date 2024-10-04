<?php
$variables_path = get_template_directory() . '/template-parts/_variables_seccion.php';
include($variables_path);
if($opciones_de_seccion['ocultar_contenido']) return;
$barra = $contenido['contenido_barra_lateral'];
$content = $contenido['contenido'];
?>
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
        <div class="row row-gap-5">
            <div class="col-md-3 d-flex flex-column row-gap-3 text-md-start text-center align-items-md-start align-items-center">
                <!-- imagen -->
                 <?php if($barra['imagen']): ?>
                 <img src="<?php echo $barra['imagen'] ?>" alt="imagen-isil"
                    width="72" height="72"
                    style="width:<?php echo ($barra['tamano_de_la_imagen'])?$barra['tamano_de_la_imagen']:"100%" ?>; height:auto"
                    >
                <?php endif ?>
                <!-- imagen -->
                <!-- título -->
                <?php if($barra['titulo']): ?>
                <h2 class="text-primary mb-0"><?php echo $barra['titulo'] ?></h2>
                <?php endif ?>
                <!-- título -->
                <!-- descripción -->
                <?php if($barra['descripcion']): ?>
                <div class="contenedor-textos-isil">
                    <?php echo $barra['descripcion'] ?>
                </div>
                <?php endif ?>
                <!-- descripción -->
            </div>
            <div class="col-md-9 d-flex flex-column row-gap-3 text-md-start text-center align-items-md-start align-items-center  <?php echo ($contenido['barra_a_la_derecha'])? "order-first":"" ?>">
                <!-- imagen -->
                <?php if($content['imagen']): ?>
                <img src="<?php echo $content['imagen'] ?>" alt="imagen-isil"
                    width="72" height="72"
                    style="width:<?php echo ($content['tamano_de_la_imagen'])?$content['tamano_de_la_imagen']:"100%" ?>; height:auto"
                    >
                <?php endif ?>
                <!-- imagen -->
                <!-- título -->
                <?php if($content['titulo']): ?>
                <h2 class="text-primary mb-0"><?php echo $content['titulo'] ?></h2>
                <?php endif ?>
                <!-- título -->
                <!-- descripción -->
                <?php if($content['descripcion']): ?>
                <div class="contenedor-textos-isil">
                    <?php echo $content['descripcion'] ?>
                </div>
                <?php endif ?>
                <!-- descripción -->
            </div>
        </div>
    </div>
</section>