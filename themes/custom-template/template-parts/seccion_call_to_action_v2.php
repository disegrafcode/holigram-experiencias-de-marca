<?php
$variables_path = get_template_directory() . '/template-parts/_variables_seccion.php';
include($variables_path);
if($opciones_de_seccion['ocultar_contenido']) return;
$_cont = $contenido['contenido'];
?>

<!-- SECCION CALL TO ACTION 2 -->
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
    <div class="row">
            <div class="col-md-10">
                <div class="d-flex flex-md-row flex-column align-items-center">
                    <!-- imagen -->
                    <?php if($_cont['imagen']): ?>
                    <span>
                        <img src="<?php echo $_cont['imagen'] ?>" alt="rules"
                            width="100" height="auto"
                             style="width:<?php echo ($_cont['tamano_de_la_imagen'])?$_cont['tamano_de_la_imagen']:"100%" ?>; height:auto"
                        >
                    </span>
                    <?php endif ?>
                    <!-- imagen -->
                    <div class="px-md-3 px-0">
                        <!-- subtitulo -->
                        <?php if($_cont['subtitulo']): ?>
                         <span
                         style="color:<?php echo $_cont['subtitulo_color'] ?>"
                         >
                           <?php echo $_cont['subtitulo'] ?> 
                         </span>   
                        <?php endif ?>
                        <!-- subtitulo -->
                        <!-- titulo -->
                        <?php if($_cont['titulo']): ?>
                        <h2 class="text-md-start text-center"
                            style="color:<?php echo $_cont['titulo_color'] ?>"
                        >
                            <?php echo $_cont['titulo'] ?>
                        </h2>
                        <?php endif ?>
                        <!-- titulo -->
                        <!-- descripción -->
                        <?php if($_cont['descripcion']): ?>
                        <div class="text-md-start text-center"
                        style="color:<?php echo $_cont['descripcion_color'] ?>"
                        >
                            <?php echo $_cont['descripcion'] ?>
                        </div>
                        <?php endif ?>
                        <!-- descripción -->
                    </div>
                </div>
            </div>
            <!-- botón -->
            <?php if($_cont['boton']): ?>
            <div class="col-md-2 d-md-flex d-block align-items-center text-center">
                <a href="<?php echo $_cont['url'] ?>" class="btn btn-isil-v1"
                style="color:<?php echo $_cont['color_del_boton'] ?>;background-color:<?php echo $_cont['color_de_fondo_del_boton'] ?>"
                >
                    <?php echo $_cont['boton'] ?>
                </a>
            </div>
            <?php endif ?>
            <!-- botón -->
        </div>
    </div>
</section>
<!-- SECCION CALL TO ACTION 2 -->