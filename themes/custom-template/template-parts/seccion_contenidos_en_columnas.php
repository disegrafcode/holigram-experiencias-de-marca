<?php
$variables_path = get_template_directory() . '/template-parts/_variables_seccion.php';
include($variables_path);
if($opciones_de_seccion['ocultar_contenido']) return;

$contenidos_seccion =  $contenido['contenidos'];
$columnas = ($contenido['columnas'])?$contenido['columnas']:4;

if(!$contenidos_seccion)
{
    exit();
}


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
    <div class="<?php echo($ancho_completo_seccion)?"container-fluid":"container" ?>">
        <div class="row row-gap-4">
            <!-- titulo de la sección -->
            <?php if($contenido['titulo']): ?>
            <div class="col-md-12">
                <div class="h1 text-center"><?php echo $contenido['titulo'] ?></div>
            </div>
            <?php endif ?>
            <!-- titulo de la sección -->
            <?php foreach($contenidos_seccion AS $key=>$content): ?>
            <div class="col-md-<?php echo $columnas ?> px-md-4 px-2">
                <div class="item_<?php echo $key ?>">
                    <!-- imagen -->
                    <?php if($content['imagen']):?>
                    <?php
                        $clase_generada = '';
                        $ocultar = $content['visibilidad_de_la_imagen'];
                        sort($ocultar);
                        $ocultar_key = implode(',', $ocultar);

                        switch ($ocultar_key) {
                            case 'desktop':
                                $clase_generada = 'd-md-none d-block';
                                break;
                            case 'mobile':
                                $clase_generada = 'd-md-block d-none';
                                break;
                            case 'desktop,mobile':
                                $clase_generada = 'd-none';
                                break;
                        }
                    ?>
                    <img src="<?php echo $content['imagen'] ?>" alt="icon"
                        width="78" height="78" class="mb-3 contenido-imagen <?php echo $clase_generada ?>"
                        style="width:<?php echo ($content['tamano_de_la_imagen'])?$content['tamano_de_la_imagen']:"100%" ?>; height:auto"
                        >
                    <?php endif ?>
                    <!-- imagen -->
                    <!-- subtitulo -->
                    <?php if($content['subtitulo']): ?>
                    <span class="isil-biblioteca-subtitulo"
                    style="color:<?php echo $content['subtitulo_color'] ?>"
                    >
                        <?php echo $content['subtitulo'] ?>
                    </span>
                    <?php endif ?>
                    <!-- subtitulo -->
                    <!-- titulo -->
                    <?php if($content['titulo']): ?>
                    <h2 class="h3 isil-biblioteca-linea-inicio isil-biblioteca-titulo mb-3"
                    style="color:<?php echo $content['titulo_color'] ?>"
                    >
                    <?php echo $content['titulo'] ?>
                    </h2>
                    <?php endif ?>
                    <!-- titulo -->
                    <!-- contenido -->
                    <?php if($content['descripcion']):?>
                    <div class="contenedor-textos-isil"
                    style="color:<?php echo $content['descripcion_color'] ?>"
                    >
                        <?php echo $content['descripcion'] ?>
                    </div>
                    <?php endif ?>
                    <!-- contenido -->
                     <!-- botón -->
                    <?php if($content['boton']): ?>
                    <div class="text-md-start text-center my-3">
                        <a href="<?php echo $content['url'] ?>" class="btn btn-isil-v1"
                        style="color:<?php echo $content['boton_color_de_texto'] ?>;background-color:<?php echo $content['boton_color_de_fondo'] ?>"
                        >
                            <?php echo $content['boton'] ?>
                        </a>
                    </div>
                    <?php endif ?>
                    <!-- botón -->
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
</section>