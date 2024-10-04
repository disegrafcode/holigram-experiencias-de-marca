<?php
require_once dirname(__FILE__) . '/includes/seguridad_wordpress.php'; /* SCRIPTS PARA DAR SEGURIDAD A WORDPRESS */
require_once dirname(__FILE__) . '/includes/custom_search_form.php'; /* CUSTOM SEARCH FORM */
require_once dirname(__FILE__) . '/includes/funciones.php'; /* CUSTOM SEARCH FORM */
require_once dirname(__FILE__) . '/includes/pagina-de-opciones.php'; /* CREAMOS PÁGINA DE OPCIONES PARA AL WEB */
require_once dirname(__FILE__) . '/includes/shortcodes.php'; /* SHORTCODES DE LA WEB */

/* INSERTA EL ESTILO CSS DEL BOOTSTRAP */
function main_style_theme()
{
    wp_enqueue_style('main_style_theme', get_stylesheet_directory_uri() . '/assets/bootstrap-5.3.3/css/bootstrap.min.css', array(), '1.0');
}
add_action('wp_enqueue_scripts', 'main_style_theme');
/* INSERTA EL ESTILO CSS DEL BOOTSTRAP */

/* AGREGA EL CSS DE BOOTSTRAP AL EDITOR TINYMCE  */
function bootstrap_mce_styles() {
    add_editor_style(get_stylesheet_directory_uri() . '/assets/bootstrap-5.3.3/css/bootstrap.min.css');
}
add_action('admin_init', 'bootstrap_mce_styles');
/* AGREGA EL CSS DE BOOTSTRAP AL EDITOR TINYMCE  */

/* INSERTAR JAVASCRIPT DE BOOTSTRAP */
function bootstrap_script_enqueue_scripts()
{
    wp_register_script('bootstrap-script', get_template_directory_uri() . '/assets/bootstrap-5.3.3/js/bootstrap.bundle.min.js', array(), '1.0.0', true);
    wp_enqueue_script('bootstrap-script');
}
add_action('wp_enqueue_scripts', 'bootstrap_script_enqueue_scripts');
/* INSERTAR JAVASCRIPT DE BOOTSTRAP */

/* INSERTAR SWIPER SLIDER */
function agregar_swiper_assets() {
    wp_enqueue_style(
        'swiper-css', 
        get_template_directory_uri() . '/assets/swiper.11.1.4/swiper.min.css', 
        array(), 
        '11.1.4'
    );
    wp_enqueue_script(
        'swiper-js', 
        get_template_directory_uri() . '/assets/swiper.11.1.4/swiper.min.js', 
        array('jquery'),
        '11.1.4', 
        true
    );
}
add_action('wp_enqueue_scripts', 'agregar_swiper_assets');
/* INSERTAR SWIPER SLIDER */

/* CUSTOM CSS PARA EL TEMA */
function enqueue_custom_styles() {
    // Asegúrate de ajustar la ruta del archivo CSS según la estructura de tu tema
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/assets/css/custom_style.css', array(), '1.1.1', 'all');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');
/* CUSTOM CSS PARA EL TEMA */

/* AGREGA CUSTOM CSS AL EDITOR TINYMCE  */
function custom_mce_styles() {
    add_editor_style(get_template_directory_uri() . '/assets/css/custom_style.css');
}
add_action('admin_init', 'custom_mce_styles');
/* AGREGA CUSTOM CSS AL EDITOR TINYMCE  */

/* AGREGAR CUSTOM FONTS A LA WEB */
function enqueue_custom_fonts() {
    wp_enqueue_style('custom-fonts', get_template_directory_uri() . '/assets/fonts/stylesheet.css', array(), '1.0');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_fonts');
/* AGREGAR CUSTOM FONTS A LA WEB */


add_action('after_setup_theme', 'customTemplate_setup');
function customTemplate_setup()
{
    load_theme_textdomain('customTemplate', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'navigation-widgets'));
    add_theme_support('woocommerce');
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1920;
    }
    register_nav_menus(array('main-menu' => esc_html__('Main Menu', 'customTemplate')));
}

add_action('wp_enqueue_scripts', 'customTemplate_enqueue');
function customTemplate_enqueue()
{
    wp_enqueue_style('customTemplate-style', get_stylesheet_uri());
    wp_enqueue_script('jquery');
}

add_filter('document_title_separator', 'customTemplate_document_title_separator');
function customTemplate_document_title_separator($sep)
{
    $sep = esc_html('|');
    return $sep;
}

add_filter('the_title', 'customTemplate_title');
function customTemplate_title($title)
{
    if ($title == '') {
        return esc_html('...');
    } else {
        return wp_kses_post($title);
    }
}

/* AGREGA EL FAVICON Y LOGOTIPO EN CUSTOMIZE DENTRO DE APARIENCIA */
function agregar_personalizacion_logotipo($wp_customize)
{
    $wp_customize->add_setting('logotipo', array(
        'default' => '',
        'transport' => 'refresh',
    )
    );

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'logotipo', array(
        'label' => __('Selecciona tu logotipo de marca', 'textdomain'),
        'section' => 'title_tagline',
        'settings' => 'logotipo',
    )
    ));
}
add_action('customize_register', 'agregar_personalizacion_logotipo');
/* AGREGA EL FAVICON Y LOGOTIPO EN CUSTOMIZE DENTRO DE APARIENCIA */

/* REGISTRA 4 WIDGETS EN EL FOOTER */
function registrar_widgets_footer() {

    // Primer widget en el footer
    register_sidebar( array(
        'name'          => __( 'Footer Widget 1', 'textdomain' ),
        'id'            => 'footer-1',
        'description'   => __( 'Primer widget en el footer.', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    // Segundo widget en el footer
    register_sidebar( array(
        'name'          => __( 'Footer Widget 2', 'textdomain' ),
        'id'            => 'footer-2',
        'description'   => __( 'Segundo widget en el footer.', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    // Tercer widget en el footer
    register_sidebar( array(
        'name'          => __( 'Footer Widget 3', 'textdomain' ),
        'id'            => 'footer-3',
        'description'   => __( 'Tercer widget en el footer.', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    // Cuarto widget en el footer
    register_sidebar( array(
        'name'          => __( 'Footer Widget 4', 'textdomain' ),
        'id'            => 'footer-4',
        'description'   => __( 'Cuarto widget en el footer.', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}

// Hook para registrar las áreas de widgets
add_action( 'widgets_init', 'registrar_widgets_footer' );
/* REGISTRA 4 WIDGETS EN EL FOOTER */

/* AGREGA CAMPOS DE EN EL PERZONALIZADOR DE TEMAS */
function mytheme_customize_register($wp_customize)
{
    $wp_customize->add_section('custom_code_section', array(
        'title' => __('Custom Code', 'mytheme'),
        'priority' => 30,
    )
    );

    // Agregar control de CodeMirror para el CSS del encabezado
    $wp_customize->add_setting('header_css', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    )
    );
    $wp_customize->add_control(
        new WP_Customize_Code_Editor_Control(
            $wp_customize,
            'header_css',
            array(
                'label' => __('Header CSS', 'mytheme'),
                'section' => 'custom_code_section',
                'settings' => 'header_css',
                'code_type' => 'text/css',
            )
        )
    );

    // Agregar control de CodeMirror para el JavaScript del encabezado
    $wp_customize->add_setting('header_js', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    )
    );
    $wp_customize->add_control(
        new WP_Customize_Code_Editor_Control(
            $wp_customize,
            'header_js',
            array(
                'label' => __('Header JavaScript', 'mytheme'),
                'section' => 'custom_code_section',
                'settings' => 'header_js',
                'code_type' => 'text/javascript',
            )
        )
    );

    // Agregar control de CodeMirror para el CSS del pie de página
    $wp_customize->add_setting('footer_css', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    )
    );
    $wp_customize->add_control(
        new WP_Customize_Code_Editor_Control(
            $wp_customize,
            'footer_css',
            array(
                'label' => __('Footer CSS', 'mytheme'),
                'section' => 'custom_code_section',
                'settings' => 'footer_css',
                'code_type' => 'text/css',
            )
        )
    );

    // Agregar control de CodeMirror para el JavaScript del pie de página
    $wp_customize->add_setting('footer_js', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    )
    );
    $wp_customize->add_control(
        new WP_Customize_Code_Editor_Control(
            $wp_customize,
            'footer_js',
            array(
                'label' => __('Footer JavaScript', 'mytheme'),
                'section' => 'custom_code_section',
                'settings' => 'footer_js',
                'code_type' => 'text/javascript',
            )
        )
    );
}
add_action('customize_register', 'mytheme_customize_register');

function mytheme_header_code()
{
    $header_css = get_theme_mod('header_css');
    $header_js = get_theme_mod('header_js');

    if ($header_css) {
        echo '<style type="text/css">' . $header_css . '</style>';
    }
    if ($header_js) {
        echo '<script type="text/javascript">' . $header_js . '</script>';
    }
}
add_action('wp_head', 'mytheme_header_code');

function mytheme_footer_code()
{
    $footer_css = get_theme_mod('footer_css');
    $footer_js = get_theme_mod('footer_js');

    if ($footer_css) {
        echo '<style type="text/css">' . $footer_css . '</style>';
    }
    if ($footer_js) {
        echo '<script type="text/javascript">' . $footer_js . '</script>';
    }
}
add_action('wp_footer', 'mytheme_footer_code');
/* AGREGA CAMPOS DE EN EL PERZONALIZADOR DE TEMAS */

/* MODO MANTENINIENTO EN WORDPRESS */
function mytheme_customize_register_maintenance_mode_section($wp_customize)
{
    $wp_customize->add_section('maintenance_mode_section', array(
        'title' => __('Modo Mantenimiento', 'mytheme'),
        'priority' => 30,
    )
    );

    $wp_customize->add_setting('maintenance_mode_active', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    )
    );

    $wp_customize->add_control('maintenance_mode_active', array(
        'label' => __('Activar Modo Mantenimiento', 'mytheme'),
        'section' => 'maintenance_mode_section',
        'settings' => 'maintenance_mode_active',
        'type' => 'checkbox',
    )
    );

    $wp_customize->add_setting('maintenance_mode_title', array(
        'default' => __('Website Under Maintenance', 'mytheme'),
        'sanitize_callback' => 'sanitize_text_field',
    )
    );

    $wp_customize->add_control('maintenance_mode_title', array(
        'label' => __('Título del Modo Mantenimiento', 'mytheme'),
        'section' => 'maintenance_mode_section',
        'settings' => 'maintenance_mode_title',
        'type' => 'text',
    )
    );

    $wp_customize->add_setting('maintenance_mode_description', array(
        'default' => __('We are currently performing scheduled maintenance. Please check back soon.', 'mytheme'),
        'sanitize_callback' => 'sanitize_textarea_field',
    )
    );

    $wp_customize->add_control('maintenance_mode_description', array(
        'label' => __('Descripción del Modo Mantenimiento', 'mytheme'),
        'section' => 'maintenance_mode_section',
        'settings' => 'maintenance_mode_description',
        'type' => 'textarea',
    )
    );
}
add_action('customize_register', 'mytheme_customize_register_maintenance_mode_section');
/* MODO MANTENINIENTO EN WORDPRESS */
function custom_maintenance_mode()
{
    if (!get_theme_mod('maintenance_mode_active', false)) {
        return;
    }

    if (current_user_can('manage_options')) {
        return;
    }

    if (is_admin() || $GLOBALS['pagenow'] === 'wp-login.php') {
        return;
    }

    $title = get_theme_mod('maintenance_mode_title', __('Website Under Maintenance', 'mytheme'));
    $description = get_theme_mod('maintenance_mode_description', __('We are currently performing scheduled maintenance. Please check back soon.', 'mytheme'));

    wp_die(
        '<h1>' . esc_html($title) . '</h1><p>' . esc_html($description) . '</p>',
        'Maintenance Mode',
        array('response' => 503)
    );
}
add_action('get_header', 'custom_maintenance_mode');

/* MODO MANTENINIENTO EN WORDPRESS */

/* AGRANDA LA ALTURA DEL CODEMIRROR DE WORDPRESS */
function custom_codemirror_styles()
{
    ?>
    <style>
        .wp-customizer .CodeMirror {
            height: 600px;
        }
    </style>
    <?php
}
add_action('customize_controls_print_styles', 'custom_codemirror_styles');
/* AGRANDA LA ALTURA DEL CODEMIRROR DE WORDPRESS */

/* AGREGAR LA BARRA DE ADMINISTRACIÓN A TODA LA WEB */
add_action('wp_footer', 'toggle_admin_bar_button');
function toggle_admin_bar_button() {
    if (current_user_can('administrator') || current_user_can('editor') ) {
        echo '<button id="toggle-admin-bar-button" style="position: fixed; bottom: 10px; right: 10px; z-index: 9999;" aria-label="Mostrar / Ocultar Barra de Administración"><span class="dashicons dashicons-admin-tools"></span></button>';
    }
}

add_action('wp_footer', 'toggle_admin_bar_script');
function toggle_admin_bar_script() {
    if (current_user_can('administrator') || current_user_can('editor') ) {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var adminBar = document.getElementById('wpadminbar');
            adminBar.style.display = 'none';

            var adminBarButton = document.getElementById('toggle-admin-bar-button');
            adminBarButton.addEventListener('click', function() {
                adminBar.style.display = (adminBar.style.display === 'none') ? 'block' : 'none';
                var icon = this.querySelector('.dashicons');
                icon.classList.toggle('dashicons-admin-tools');
                icon.classList.toggle('dashicons-hidden');

                if (adminBar.style.display === 'block') {
                    document.documentElement.style.marginTop = '0';
                } else {
                    document.documentElement.style.marginTop = '0';
                }
            });

            adminBarButton.addEventListener('mouseover', function() {
                this.setAttribute('title', adminBar.style.display === 'none' ? 'Mostrar Barra de Administración' : 'Ocultar Barra de Administración');
            });
        });
        </script>
        <?php
    }
}

add_action('get_header', 'remove_admin_bar_margin');
function remove_admin_bar_margin() {
    remove_action('wp_head', '_admin_bar_bump_cb');
}
/* AGREGAR LA BARRA DE ADMINISTRACIÓN A TODA LA WEB */

/* AGREGAR OPCIONES DE OCULTAR BUSCADOR */
add_action('customize_register', 'custom_menu_search_hide_option');
function custom_menu_search_hide_option($wp_customize) {
    // Añadir una sección
    $wp_customize->add_section('menu_settings', array(
        'title' => __('Ajustes de Menú', 'textdomain'),
        'priority' => 30,
    ));

    // Añadir un control de checkbox para ocultar el buscador del menú
    $wp_customize->add_setting('hide_menu_search', array(
        'default' => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('hide_menu_search', array(
        'label' => __('Ocultar buscador del menú', 'textdomain'),
        'section' => 'menu_settings',
        'type' => 'checkbox',
    ));
}
/* AGREGAR OPCIONES DE OCULTAR BUSCADOR */

/* DISABLE GUTEMBER EDITOR EN LA TEMPLATE ISIL */
function disable_gutenberg_for_isil_template_base($can_edit, $post_type)
{
    if ($post_type === 'page' && get_page_template_slug(get_the_ID()) === 'isil-template.php') {
        return false;
    }
    return $can_edit;
}
add_filter('use_block_editor_for_post_type', 'disable_gutenberg_for_isil_template_base', 10, 2);

function disable_gutenberg_for_specific_template($can_edit, $post)
{
    if ($post && get_page_template_slug($post->ID) === 'isil-template.php') {
        return false;
    }
    return $can_edit;
}
add_filter('use_block_editor_for_post', 'disable_gutenberg_for_specific_template', 10, 2);
/* DISABLE GUTEMBER EDITOR EN LA TEMPLATE ISIL */


/* AGREGA COLORES PERSONZALIZADOS A ADVANCED CUSTOM FIELDS */
function my_acf_custom_color_palette() {
    ?>
    <script type="text/javascript">
    (function($) {
        acf.add_filter('color_picker_args', function( args, $field ){
            args.palettes = ['#00BCFF', '#3377FF', '#F1F2F2', '#2ABA93', '#2E4259', '#FFCC3B', '#FC6A4A', '#FF4141', '#514F4F', '#BEBDBD']
            return args;
        });
    })(jQuery);
    </script>
    <?php
}
add_action('acf/input/admin_footer', 'my_acf_custom_color_palette');
/* AGREGA COLORES PERSONZALIZADOS A ADVANCED CUSTOM FIELDS */

/* AGREGAR BOTONES DE SHORTCODES EN LOS EDITORES DE TEXTO */
$_isil_version = '1.0.2';
function tiny_mce_add_buttons($plugins)
{
    global $_isil_version;
    $plugins['mytinymceplugin'] = get_template_directory_uri() . '/assets/custom_buttons_tiny/buttons-shortcode.js?ver=' . $_isil_version;
    return $plugins;
}

function tiny_mce_register_buttons($buttons)
{
    $newBtns = array(
        'btn_encabezado',
        'btn_addbutton',
        'btn_bootstrap_typography',
        'btn_imagen_texto',
    );
    $buttons = array_merge($buttons, $newBtns);
    return $buttons;
}
add_action('init', 'tiny_mce_new_buttons');

function tiny_mce_new_buttons()
{
    add_filter('mce_external_plugins', 'tiny_mce_add_buttons');
    add_filter('mce_buttons', 'tiny_mce_register_buttons');
}

function localize_tinymce_plugin()
{
    wp_localize_script('jquery', 'themeData', array(
        'themeUrl' => get_template_directory_uri()
    ));
}
add_action('admin_enqueue_scripts', 'localize_tinymce_plugin');

function agregar_css_al_footer()
{
    global $_isil_version;
    wp_register_style('isil-elements', get_template_directory_uri() . '/assets/custom_buttons_tiny/isil-elements.css', array(), $_isil_version, 'all');
    wp_enqueue_style('isil-elements');
}
add_action('wp_footer', 'agregar_css_al_footer');

function my_custom_mce_css($mce_css)
{
    global $_isil_version;
    if (!empty($mce_css)) {
        $mce_css .= ',';
    }
    $mce_css .= get_template_directory_uri() . '/assets/custom_buttons_tiny/isil-elements.css?ver=' . $_isil_version;
    return $mce_css;
}

add_filter('mce_css', 'my_custom_mce_css');

/* AGREGAR BOTONES DE SHORTCODES EN LOS EDITORES DE TEXTO */

/* SHORTCODE IMAGEN CON TEXTO */

function imagen_con_texto_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'etiqueta' => 'p',
        'image' => '',
        'size' => '',
        'color' => '#000000'
    ), $atts, 'imagen_con_texto');

    $etiqueta = sanitize_text_field($atts['etiqueta']);
    $image = esc_url($atts['image']);
    $size = $atts['size'];
    $color = $atts['color']; 
    ob_start();
    ?>
    <?php if (!empty($image) && $image) : ?>
        <<?php echo $etiqueta ?> class="d-flex column-gap-2 align-items-center" style="color:<?php echo $color ?>">
           <img src="<?php echo $image ?>" alt="icono" style="width:<?php echo $size ?>;height:auto;">
           <?php echo do_shortcode($content) ?>
        </<?php echo $etiqueta ?>>
    <?php endif ?>
    <?php
    return ob_get_clean();
}
add_shortcode('imagen_con_texto', 'imagen_con_texto_shortcode');

/* SHORTCODE IMAGEN CON TEXTO */

/* INSERTAR CÓDIGO SOLO EN EL ADMIN DE WORDPRESS */
add_action('admin_init', 'custom_admin_init');

function custom_admin_init() {
    // Aquí puedes agregar cualquier otra inicialización que necesites en el admin
    // Ejemplo: Mostrar un mensaje personalizado en el admin
    add_action('admin_notices', function() {
        ?>
            <style>
                .-collapse
                {
                background-color:yellow !important;
                border: solid 1px black !important;
                display:block !important;
                }
            </style>
        <?php
    });
}
/* INSERTAR CÓDIGO SOLO EN EL ADMIN DE WORDPRESS */

/* AGREGA COLORS PERSONALIZADOS AL MCE DE WORDPRESS */
add_filter('tiny_mce_before_init', 'custom_tinymce_colors');

function custom_tinymce_colors($init) {
    $custom_colors = '
        "000000", "Black",
        "993300", "Burnt orange",
        "333300", "Dark olive",
        "003300", "Dark green",
        "003366", "Dark azure",
        "000080", "Navy Blue",
        "333399", "Indigo",
        "333333", "Very dark gray",
        "800000", "Maroon",
        "FF6600", "Orange",
        "808000", "Olive",
        "008000", "Green",
        "008080", "Teal",
        "0000FF", "Blue",
        "666699", "Grayish blue",
        "808080", "Gray",
        "FF0000", "Red",
        "FF9900", "Amber",
        "99CC00", "Yellow green",
        "339966", "Sea green",
        "33CCCC", "Turquoise",
        "3366FF", "Royal blue",
        "800080", "Purple",
        "999999", "Medium gray",
        "FF00FF", "Magenta",
        "FFCC00", "Gold",
        "FFFF00", "Yellow",
        "00FF00", "Lime",
        "00FFFF", "Aqua",
        "00CCFF", "Sky blue",
        "993366", "Red violet",
        "FFFFFF", "White",
        "FF99CC", "Pink",
        "FFCC99", "Peach",
        "FFFF99", "Light yellow",
        "CCFFCC", "Pale green",
        "CCFFFF", "Pale cyan",
        "99CCFF", "Light sky blue",
        "CC99FF", "Plum",
        "00BCFF", "Custom Blue",
        "3377FF", "Custom Dark Blue",
        "F1F2F2", "Custom Light Gray",
        "2ABA93", "Custom Green",
        "2E4259", "Custom Dark Gray",
        "FFCC3B", "Custom Yellow",
        "FC6A4A", "Custom Orange",
        "FF4141", "Custom Red",
        "514F4F", "Custom Dark Gray",
        "BEBDBD", "Custom Medium Gray"
    ';

    $init['textcolor_map'] = '[' . $custom_colors . ']';
    $init['textcolor_rows'] = 6;

    return $init;
}
/* AGREGA COLORS PERSONALIZADOS AL MCE DE WORDPRESS */

/* SHORTCODE DE REGISTRO DE EMPRESA */
function empresa_registro_formulario_shortcode() {
    ob_start();
    $file_path = get_template_directory(). '/template-parts/formulario-empresa.php';
    if (file_exists($file_path)):
        include $file_path;
    else:
        echo "Error, no se encontró Formulario de registro de empresa";
    endif;
    return ob_get_clean();
}

add_shortcode('empresa_registro_formulario', 'empresa_registro_formulario_shortcode');
/* SHORTCODE DE REGISTRO DE EMPRESA */


/* AGREGAR CODEMIRROR A TEXTAREA DE CODIGO */
function enqueue_codemirror_assets($hook_suffix) {
    wp_enqueue_code_editor(array('type' => 'text/html'));
    wp_enqueue_script('wp-theme-plugin-editor');
    wp_enqueue_style('wp-codemirror');
}
add_action('admin_enqueue_scripts', 'enqueue_codemirror_assets');

// Función para inicializar CodeMirror
function add_codemirror_inline_script() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        wp.codeEditor.initialize($('.custom-css-codemirror textarea'), {
            codemirror: {
                lineNumbers: true,
                mode: 'css'
            }
        });
        wp.codeEditor.initialize($('.custom-js-codemirror textarea'), {
            codemirror: {
                lineNumbers: true,
                mode: 'javascript'
            }
        });
    });
    </script>
    <?php
}
add_action('admin_footer', 'add_codemirror_inline_script');
/* AGREGAR CODEMIRROR A TEXTAREA DE CODIGO */

/* MOSTRAR CODIGO CSS Y JAVASCRIPT PERSONALIZADO */
function enqueue_custom_code() {
    if (is_page()) {
        $css_code = get_field('css');
        $javascript_code = get_field('javascript');
        if (!empty($css_code)) {
            echo '<!-- css personalizado -->';
            echo '<style type="text/css">' . esc_html($css_code) . '</style>';
            echo '<!-- css personalizado -->';
        }
        if (!empty($javascript_code)) {
            echo '<!-- javascript personalizado -->';
            echo '<script type="text/javascript">' . esc_html($javascript_code) . '</script>';
            echo '<!-- javascript personalizado -->';
        }
    }
}
add_action('wp_footer', 'enqueue_custom_code', 100);
/* MOSTRAR CODIGO CSS Y JAVASCRIPT PERSONALIZADO */


/* SHORTCODE POPUP BOOTSTRAP */
function popup_video_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'url' => '',
            'button-label' => 'Ver video',
            'button-class' => 'btn btn-primary',
        ),
        $atts,
        'popup_video'
    );

    $unique_id = uniqid('popup_video_');

    preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $atts['url'], $matches);
    $video_id = $matches[1];


    ob_start();
    ?>
    <button type="button" class="<?php echo esc_attr($atts['button-class']); ?>" data-bs-toggle="modal" data-bs-target="#<?php echo esc_attr($unique_id); ?>" data-video-id="<?php echo esc_attr($video_id); ?>">
        <?php echo esc_html($atts['button-label']); ?>
    </button>
    <?php
    // Append modal container to the footer
    add_action('wp_footer', function() use ($unique_id, $atts) {
        ?>
        <div class="modal fade" id="<?php echo esc_attr($unique_id); ?>" tabindex="-1" aria-labelledby="<?php echo esc_attr($unique_id); ?>Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="<?php echo esc_attr($unique_id); ?>Label"><?php echo esc_html($atts['button-label']); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="ratio ratio-16x9">
                            <iframe src="" title="YouTube video" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var modal = document.getElementById('<?php echo esc_attr($unique_id); ?>');
                var iframe = modal.querySelector('iframe');
                var triggerButtons = document.querySelectorAll('button[data-bs-target="#<?php echo esc_attr($unique_id); ?>"]');

                triggerButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        var videoId = this.getAttribute('data-video-id');
                        iframe.src = 'https://www.youtube.com/embed/' + videoId;
                    });
                });

                modal.addEventListener('hidden.bs.modal', function () {
                    iframe.src = '';
                });
            });
        </script>
        <?php
    });

    return ob_get_clean();
}
add_shortcode('popup_video', 'popup_video_shortcode');

/* SHORTCODE POPUP BOOTSTRAP */

/* AGREGAR AL EDITOR PODER PERSONALIZAR LA WEB */
function agregar_capacidad_personalizar_a_editores() {
    $rol_editor = get_role( 'editor' );

    if ( ! empty( $rol_editor ) ) {
        $rol_editor->add_cap( 'edit_theme_options' );
    }
}

add_action( 'init', 'agregar_capacidad_personalizar_a_editores' );
/* AGREGAR AL EDITOR PODER PERSONALIZAR LA WEB */