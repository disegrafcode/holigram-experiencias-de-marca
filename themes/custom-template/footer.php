</main>
<?php get_sidebar(); ?>
</div>

<footer class="page-footer font-small bg-primary text-white pt-4">
    <div class="container my-4 ">
        <div class="row">
            <div class="col-lg-3 text-center text-md-start py-4">
                <?php dynamic_sidebar('footer-widget-1'); ?>
            </div>
            <div class="col-lg-3 text-center text-md-start py-4">
                <?php dynamic_sidebar('footer-widget-2'); ?>
            </div>

            <div class="col-lg-3 text-center text-md-start py-4">
                <?php dynamic_sidebar('footer-widget-3'); ?>
            </div>

            <div class="col-lg-3 text-center text-md-start py-4">
                <?php dynamic_sidebar('footer-widget-4'); ?>
            </div>
        </div>
    </div>
    <div class="bg-black bg-opacity-25">
        <div class="container py-3">
            <div class="row">
                <div class="col small text-center">
                    © <?php echo esc_html(date_i18n(__('Y', 'customTemplate'))); ?> <?php echo esc_html(get_bloginfo('name')); ?>
                    todos los derechos reservados. Desarrollado por <a href="https://holigram.pe/" target="_blank" rel="noopener noreferrer"> holigram.pe</a>
                </div>
            </div>
        </div>
    </div>
</footer>

</div>

<?php wp_footer(); ?>

</body>

</html>