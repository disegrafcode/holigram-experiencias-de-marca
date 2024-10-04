<?php
$variables_path = get_template_directory() . '/template-parts/_variables_seccion.php';
include($variables_path);

/* ITEMS DE PORCENTAJES */
$cuadros = $contenido['cuadros'];
$columnas = ($contenido['columnas'])?$contenido['columnas']:4;
/* ITEMS DE PORCENTAJES */

?>
<!-- SECCIÓN RECUADRO CON PORCENTAJES -->
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
        <div class="row justify-sm-content-between justify-content-center row-gap-3">
            <?php if($cuadros): ?>
                <?php foreach($cuadros AS $key=>$cuadro): ?>
                    <!-- item porcentaje -->
                    <div class="col-sm-<?php echo $columnas ?>" id="isil-item-per-<?php echo $key ?>">
                        <div class="isil-items-porcentaje text-center p-5 mx-auto"
                        style="background-color:<?php echo $cuadro['color_de_fondo'] ?>;color:<?php echo $cuadro['color_de_texto'] ?>"
                        >
                            <div class="h1 mb-0">
                                <?php echo $cuadro['porcentaje'] ?>
                            </div>
                            <p class="mb-0 font-size-12px">
                                <?php echo $cuadro['descripcion'] ?>
                            </p>
                        </div>
                    </div>
                    <!-- item porcentaje -->
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
</section>
<!-- SECCIÓN RECUADRO CON PORCENTAJES -->