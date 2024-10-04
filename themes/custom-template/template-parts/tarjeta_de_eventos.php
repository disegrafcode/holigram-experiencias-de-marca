<?php
$slides = $pestana['tarjetas_contenido'];
if(!$slides) exit();
$id_tarjeta_slider = $tab_id."_contenido_".$key."_tarjeta_slide";
$opciones_slider = $pestana['opciones_de_slider'];
?>
<!-- contenido tab2 -->
<div class="container px-0">
    <div class="swiper isil-eventos px-5" id="<?php echo $id_tarjeta_slider ?>">
        <div class="swiper-wrapper">
            <?php foreach($slides AS $key=>$slide): ?>
            <!-- items -->
            <div class="swiper-slide">
                <div class="contenedor-textos-isil">
                    <!-- imagen -->
                    <?php if($slide['imagen']): ?>
                    <img src="<?php echo $slide['imagen'] ?>" alt="image-event" class="img-fluid mb-3">
                    <?php endif ?>
                    <!-- imagen -->
                    <!-- titulo -->
                    <?php if($slide['titulo']): ?>      
                    <h4><?php echo $slide['titulo'] ?></h4>
                    <?php endif ?>
                    <!-- titulo --> 
                    <!-- fecha -->
                    <?php if($slide['fecha']): ?>
                    <span><?php echo $slide['fecha'] ?></span>
                    <?php endif ?>
                    <!-- fecha -->
                    <!-- descripción -->
                    <?php if($slide['descripcion']): ?>
                    <?php echo $slide['descripcion'] ?>
                    <?php endif ?>
                    <!-- descripción -->
                </div>
            </div>
            <!-- items -->
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
        const swiper_eventos = new Swiper("#<?php echo $id_tarjeta_slider ?>", {
            /* opciones de autoplay */
            <?php if($opciones_slider['autoplay']): ?>
            autoplay: {
                delay: <?php echo ($opciones_slider['tiempo_autoplay'])?$opciones_slider['tiempo_autoplay']:"500";  ?>,
                disableOnInteraction: true,
            },
            <?php endif ?>
            /* opciones de autoplay */
            slidesPerView: 1,
            spaceBetween: 50,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 50,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 50,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 50,
                },
            },

        });
    });
    </script>
</div>
<!-- contenido tab2 -->