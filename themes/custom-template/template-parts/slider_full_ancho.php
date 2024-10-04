<?php
$variables_path = get_template_directory() . '/template-parts/_variables_seccion.php';
include($variables_path);
if($opciones_de_seccion['ocultar_contenido']) return;
$section_key_number = $key;
$slider_key = "isil_slider_full_ancho".$section_key_number;
$opciones_slider = $contenido['opciones_de_slider'];
$sliders = $contenido["slides"];
?>
<!-- SECCIÓN BANNER ISIL -->
<section
    class="isil-slider show-preload <?php echo $inicial_class ?> <?php echo $clase_personalizada ?>"
    id="<?php echo $section_id ?>"
    data-template="<?php echo $template_name ?>"
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

    <div class="swiper isil-banner <?php echo $slider_key ?> <?php echo ($ancho_completo_seccion)?"container-fluid":"container" ?>">
        <div class="swiper-wrapper">
            <?php if($sliders): ?>
                <?php foreach($sliders AS $orden =>$slider): ?>
                    <?php
                        $url = ($slider['url'])? $slider['url']:"javascript:void(0)";
                        $target = ($slider['url'])? "target='_blank'": "";
                        $title = ($slider['descripcion'])? 'title="'.strip_tags($slider['descripcion']).'"': "";
                    ?>
                    <!-- slider item -->
                    <a class="swiper-slide"
                        data-orden="<?php echo $orden ?>"
                        href="<?php echo $url ?>"
                        <?php echo $title ?>
                        <?php echo $target ?>
                    >
                    </a>
                    <!-- slider item -->
                <?php endforeach ?>
            <?php endif ?>
        </div>

        <!-- flechas de navegación -->
        <?php if($opciones_slider['mostrar_flechas_de_navegacion']): ?>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <?php endif ?>
        <!-- flechas de navegación -->

        <!-- paginación -->
        <?php if($opciones_slider['mostrar_paginacion']): ?>
        <div class="swiper-pagination"></div>
        <?php endif ?>
        <!-- paginación -->
    </div>
    <style>

    /* imagenes de los slider pc */
    <?php foreach($sliders AS $orden =>$slider): ?>
    <?php echo ".".$slider_key ?> .swiper-slide:nth-child(<?php echo intval($orden)+1 ?>) {
        background-image: url("<?php echo $slider['imagen'] ?>");
    }
    <?php endforeach ?>
    /* imagenes de los slider pc */

    /* imagenes de los slider mobile */
    @media only screen and (max-width: 767px) {
        <?php foreach($sliders AS $orden =>$slider): ?>
        <?php echo ".".$slider_key ?> .swiper-slide:nth-child(<?php echo intval($orden)+1 ?>) {
            background-image: url("<?php echo $slider['imagen_mobile'] ?>");
        }
        <?php endforeach ?>
    }
    /* imagenes de los slider mobile */
    </style>

    <script>
    jQuery(window).on('load', function() {
        const swiper = new Swiper('.<?php echo $slider_key ?>', {
            centeredSlides: true,
            <?php if($opciones_slider['autoplay']): ?>
            /* opciones de autoplay */
            autoplay: {
                delay: <?php echo ($opciones_slider['tiempo_autoplay'])?$opciones_slider['tiempo_autoplay']:"500";  ?>,
                disableOnInteraction: true,
            },
            <?php endif ?>
            /* opciones de autoplay */
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    });
    </script>
</section>
<!-- SECCIÓN BANNER ISIL -->