<?php
$variables_path = get_template_directory() . '/template-parts/_variables_seccion.php';
include($variables_path);
if($opciones_de_seccion['ocultar_contenido']) return;
$columnas = ($contenido['columnas'])?$contenido['columnas']:4;
$tarjetas = $contenido['tarjetas'];
if(!$tarjetas) return;
?>

<!-- SECCION CON TARJETAS  -->
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
        <div class="row justify-content-center g-3">
            <?php foreach($tarjetas AS $tarjeta): ?>
            <!-- item tarjeta -->
            <div class="col-lg-<?php echo $columnas ?>">
                <div class="card isil-biblioteca-tarjeta-v3">
                    <!-- imagen principal -->
                    <?php if($tarjeta['imagen']): ?>
                    <img src="<?php echo $tarjeta['imagen'] ?>" class="card-img-top" alt="imagen">
                    <?php endif ?>
                    <!-- imagen principal -->
                    <div class="card-body">
                       <div class="tarjeta-v3-contenido">
                        <!-- icono principal -->
                        <?php if($tarjeta['icono']): ?>
                        <span class="tarjeta-v3-icono">
                            <img src="<?php echo $tarjeta['icono'] ?>" alt="icono"
                            style="width:<?php echo ($tarjeta['tamano_de_la_imagen'])?$tarjeta['tamano_de_la_imagen']:"100%" ?>; height:auto"                        
                            >
                        </span>
                        <?php endif ?>
                        <!-- icono principal -->
                        <!-- subtitulo -->
                        <?php if($tarjeta['subtitulo']): ?>
                            <span class="d-block small" style="color:<?php echo $tarjeta['color_de_subtitulo'] ?>">
                                <?php echo $tarjeta['subtitulo'] ?>
                            </span>
                        <?php endif ?>
                        <!-- subtitulo -->
                        <!-- titulo -->
                        <?php if($tarjeta['titulo']): ?>
                            <div class="card-title h5" style="color:<?php echo $tarjeta['color_de_titulo'] ?>">
                                <?php echo $tarjeta['titulo'] ?>
                            </div>
                        <?php endif ?>
                        <!-- titulo -->
                        <!-- descripcion -->
                        <?php if($tarjeta['descripcion']): ?>
                        <div style="color:<?php echo $tarjeta['color_descripcion'] ?>">
                            <?php echo $tarjeta['descripcion'] ?>
                        </div>
                        <?php endif ?>
                        <!-- descripcion -->
                        </div>         
                        <!-- botón -->
                        <?php $boton = $tarjeta['boton'] ?>
                        <?php if($boton['texto']): ?>
                        <div class="text-center">
                        <a href="<?php echo $boton['url'] ?>" target="_blank" class="btn btn-isil-v1 btn-isil-icon-download-file px-4"
                        style="background-color:<?php echo $boton['color_de_fondo'] ?>;color:<?php echo $boton['color_de_texto'] ?>">
                            <?php echo $boton['texto'] ?>
                        </a>
                        </div>
                        <?php endif ?>
                        <!-- botón -->
                    </div>
                </div>
            </div>
            <!-- item tarjeta -->
             <?php endforeach ?>
        </div>
    </div>
</section>
<!-- SECCION CON TARJETAS  -->