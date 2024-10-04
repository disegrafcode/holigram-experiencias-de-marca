<?php get_header(); ?>
<?php
$image = get_theme_mod('custom_404_image');
$title = get_theme_mod('custom_404_title', __('Página no encontrada', 'mytheme'));
$description = get_theme_mod('custom_404_description', __('Lo sentimos, pero la página que buscas no se pudo encontrar.', 'mytheme'));
if(!$image)
{
    $image = get_template_directory_uri() . "/assets/images/404.jpg";
}
?>
<div class="container 404-container py-4 text-center">

    <img src="<?php echo esc_url($image) ?>" alt="404" class="w-100 mb-3" style="max-width: 300px;" draggable="false" title="<?php echo esc_attr($title) ?>" >
    <h1><?php echo esc_html($title); ?></h1>
    <p class="mb-4"><?php echo esc_html($description); ?></p>
    <?php get_search_form(); ?>
</div>

<style>
    .404-container {
        padding-top: 100px;
        text-align: center;
    }

    h1 {
        font-size: 3rem;
    }

    .search-form {
        margin-top: 50px;
    }
</style>

<?php get_footer(); ?>