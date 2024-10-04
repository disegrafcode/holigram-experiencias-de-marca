<?php
$variables_path = get_template_directory() . '/template-parts/_variables_seccion.php';
include($variables_path);
if($opciones_de_seccion['ocultar_contenido']) return;

$contenido_en_columnas =  $contenido['contenido_en_columnas'];
$columnas = ($contenido['columnas'])?$contenido['columnas']:4;

if(!$contenido_en_columnas) return;

?>

<!-- seccíon acerca de nosotros -->
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
        <div class="row py-md-5 py-0">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <!-- subtitulo -->
                        <?php if($contenido['subtitulo']): ?>
                        <span class="isil-biblioteca-subtitulo">
                            <?php echo $contenido['subtitulo'] ?>
                        </span>
                        <?php endif ?>
                        <!-- subtitulo -->
                          
                        <!-- titulo -->
                        <?php if($contenido['titulo']): ?>
                        <h2 class="h3 isil-biblioteca-linea-inicio isil-biblioteca-titulo mb-3">
                        <?php echo $contenido['titulo'] ?>
                        </h2>
                        <?php endif ?>
                        <!-- titulo -->

                        <!-- imagen en mobile -->
                        <?php if($contenido['imagen']): ?>
                        <div class="text-center my-4 img-fluid d-md-none d-block">
                            <img src="<?php echo $contenido['imagen'] ?>" alt="img" class="img-fluid">
                        </div>
                        <?php endif ?>
                        <!-- imagen en mobile -->

                        <!-- descripción -->
                        <?php if($contenido['descripcion']): ?>
                        <div>
                        <?php echo $contenido['descripcion'] ?>    
                        </div>
                        <?php endif ?>
                        <!-- descripción -->
                    </div>
                </div>
                <div class="row pt-md-4 pt-2">
                    <?php if($contenido_en_columnas): ?>
                        <?php foreach($contenido_en_columnas AS $cont_columna): ?>
                        <div class="col-md-<?php echo $columnas ?>">

                            <!-- imagen -->
                            <?php if($cont_columna['imagen']): ?>
                            <img src="<?php echo $cont_columna['imagen'] ?>" alt="icon"
                                width="73" height="73"
                                class="mb-3"
                                style="width:<?php echo ($cont_columna['tamano_de_la_imagen'])?$cont_columna['tamano_de_la_imagen']:"100%" ?>; height:auto"
                            >
                            <?php endif ?>
                            <!-- imagen -->

                            <!-- titulo -->
                            <?php if($cont_columna['titulo']): ?>
                            <h3 class="h5 text-primary isil-biblioteca-linea-inicio">
                                <?php echo $cont_columna['titulo'] ?>
                            </h3>
                            <?php endif ?>
                            <!-- titulo -->

                            <!-- descripcion -->
                             <div>                             
                            <?php if($cont_columna['descripcion']): ?>
                                <?php echo $cont_columna['descripcion'] ?>
                            <?php endif ?>
                            </div>
                            <!-- descripcion -->
                        </div>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            </div>
            <?php if($contenido['imagen']): ?>
            <div class="col-md-4 d-md-block d-none">
                <img src="<?php echo $contenido['imagen'] ?>" alt="img"
                    class="img-fluid">
            </div>
            <?php endif ?>
        </div>
    </div>
</section>
<!-- seccíon acerca de nosotros -->