<?php
$slides = $pestana['testimonios_contenido'];
if(!$slides) exit();
$id_testimonio_slider = $tab_id."_contenido_".$key."_slider";
$opciones_slider = $pestana['opciones_de_slider'];
?>

<div class="swiper isil-testimonial" id="<?php echo $id_testimonio_slider ?>">
    <div class="swiper-wrapper">
        <?php foreach($slides AS $key=>$slide): ?>
        <!-- item-testimonial -->
        <div class="swiper-slide">
            <div class="container px-5">
                <div class="row mx-md-5 mx-0 mb-5">
                    <!-- imagen -->
                    <?php if($slide['imagen']): ?>
                    <div class="col-md-4 text-center px-0">
                        <img src="<?php echo $slide['imagen'] ?>"
                            alt="testimonio-imagen" class="img-fluid rounded-circle img-thumbnail">
                    </div>
                    <?php endif ?>
                    <!-- imagen -->
                    <!-- contenido -->
                    <div class="col px-0">
                        <div class="text-md-start text-center row-gap-3 d-flex flex-column contenedor-textos-isil">
                            <?php if($slide['titulo']): ?>
                                <span class="fs-1 fw-light">
                                    <?php echo $slide['titulo'] ?>
                                </span>
                            <?php endif ?>
                            <?php echo $slide['descripcion'] ?>
                        </div>
                    </div>
                    <!-- contenido -->
                </div>
            </div>
        </div>
        <!-- item-testimonial -->
         <?php endforeach ?>
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

<script>
jQuery(window).on('load', function() {
    const swiper_eventos = new Swiper("#<?php echo $id_testimonio_slider ?>", {
        /* opciones de autoplay */
        <?php if($opciones_slider['autoplay']): ?>        
        autoplay: {
            delay: <?php echo ($opciones_slider['tiempo_autoplay'])?$opciones_slider['tiempo_autoplay']:"500";  ?>,
            disableOnInteraction: true,
        },
        <?php endif ?>
        /* opciones de autoplay */
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
});
</script>