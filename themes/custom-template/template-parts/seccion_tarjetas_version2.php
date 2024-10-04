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
                <?php $classHover = ($tarjeta['descripcion'])?"tarjeta2-isil-bilioteca-hovered":"" ?>              
                <div class="tarjeta2-isil-bilioteca <?php echo $classHover ?>">
                    <div class="descripcion-tarjeta2">
                        <div class="d-inline-block">
                        <!-- titulo -->
                        <?php if($tarjeta['titulo']): ?>
                            <span class="h3 d-block" style="color:<?php echo $tarjeta['color_de_titulo'] ?>">
                                <?php echo $tarjeta['titulo'] ?>
                            </span>
                        <?php endif ?>
                        <!-- titulo -->
                        <!-- subtitulo -->
                        <?php if($tarjeta['subtitulo']): ?>
                            <span class="h5 d-block" style="color:<?php echo $tarjeta['color_de_subtitulo'] ?>">
                                <?php echo $tarjeta['subtitulo'] ?>
                            </span>
                        <?php endif ?>
                        <!-- subtitulo -->
                        </div>    
                        <!-- descripcion -->
                        <?php if($tarjeta['descripcion']): ?>
                        <div style="color:<?php echo $tarjeta['color_descripcion'] ?>">
                            <?php echo $tarjeta['descripcion'] ?>
                        </div>
                        <?php endif ?>
                        <!-- descripcion -->
                        <!-- botón -->
                        <?php $boton = $tarjeta['boton'] ?>
                        <?php if($boton['texto']): ?>
                        <div class="text-center">
                        <a href="<?php echo $boton['url'] ?>" target="_blank" class="btn btn-tarjeta px-4"
                        style="background-color:<?php echo $boton['color_de_fondo'] ?>;color:<?php echo $boton['color_de_texto'] ?>">
                            <?php echo $boton['texto'] ?>
                        </a>
                        </div>
                        <?php endif ?>
                        <!-- botón -->
                    </div>
                    <!-- IMAGEN DE FONDO -->
                     <?php
                        $fondo = $tarjeta['fondo'];
                        $img_de_fondo_desktop = $fondo['imagen_de_fondo_desktop'];
                        $img_de_fondo_mobile = $fondo['imagen_de_fondo_mobile'];
                        if(!$img_de_fondo_desktop && $img_de_fondo_mobile)
                        {
                            $img_de_fondo_desktop = $img_de_fondo_mobile;
                        }
                        if(!$img_de_fondo_mobile && $img_de_fondo_desktop)
                        {
                            $img_de_fondo_mobile = $img_de_fondo_desktop;
                        }
                        $color_fondo = $fondo['color_de_fondo'];
                     ?>
                    <div class="section_background" style="background-color:<?php echo $color_fondo ?>">
                        <div class="desktop_background"
                        style="background-image:url('<?php echo $img_de_fondo_desktop ?>')"
                        ></div>
                        <div class="mobile_background" style="background-image:url('<?php echo $img_de_fondo_mobile ?>')"></div>
                    </div>
                    <!-- IMAGEN DE FONDO -->
                </div>
            </div>
            <!-- item tarjeta -->
             <?php endforeach ?>
        </div>
    </div>
</section>
<!-- SECCION CON TARJETAS  -->