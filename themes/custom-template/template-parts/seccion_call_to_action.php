<?php
$variables_path = get_template_directory() . '/template-parts/_variables_seccion.php';
include($variables_path);
$botones = $contenido['botones'];
?>

<!-- SECCION CON CALL TO ACTION -->
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

        <?php if($contenido['titulo']): ?>
        <!-- titulo -->
        <div class="row">
            <div class="col-md-12 text-center mb-md-4 mb-3">
                <h2><?php echo $contenido['titulo'] ?></h2>
            </div>
        </div>
        <!-- titulo -->
         <?php endif ?>

        <div class="row justify-content-md-center grid gap-3">
            <?php foreach($botones AS $key=>$boton): ?>
            <!-- botones CTA -->
            <div class="col-md position-relative p-md-0 px-2">
                <a
                    class="btn w-100 p-md-5 p-3 isil-botones-cta"
                    href="<?php echo ($boton['url'])?($boton['url']):"javascript:void(0)" ?>"
                    style="background-color:<?php echo $boton['color_de_fondo'] ?>"
                    >
                    <div class="d-md-flex d-block justify-content-center grid gap-0 column-gap-4">
                        <!-- icono del boton -->
                        <?php if($boton['imagen']): ?>
                        <img src="<?php echo $boton['imagen'] ?>" alt="icono-isil"
                            width="65" height="65">
                        <?php endif ?>
                        <!-- icono del boton -->
                        <div class="text-container" style="color:<?php echo $boton['color_de_texto'] ?>">
                            <!-- titulo del boton -->
                            <?php if($boton['titulo']): ?>
                            <div class="h3 text-md-start text-center mb-0">
                            <?php echo $boton['titulo'] ?>
                            </div>
                            <?php endif ?>
                            <!-- titulo del boton -->
                            <!-- descripción del boton -->
                            <?php if($boton['descripcion']): ?>
                            <span class="fw-light text-md-start text-center d-block">
                            <?php echo remove_paragraph_tags($boton['descripcion']) ?>
                            </span>
                            <?php endif ?>
                            <!-- descripción del boton -->
                        </div>
                    </div>
                </a>
            </div>
            <!-- botones CTA -->
            <?php endforeach ?>
        </div>
    </div>
</section>
<!-- SECCION CON CALL TO ACTION -->