<?php
/* SHORTCODE PARA RESALTAR */
function shortcode_resaltar($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'imagen' => '',
        ),
        $atts,
        'resaltar'
    );

    // Construir el HTML a renderizar
    $html = '<div class="isil-texto-resaltar">';
    $html .= '<span>';
    $html .= '<img src="' . esc_url($atts['imagen']) . '">';
    $html .= '</span>';
    $html .= '<div>';
    $html .= do_shortcode($content);
    $html .= '</div>';
    $html .= '</div>';

    return $html;
}
add_shortcode('resaltar', 'shortcode_resaltar');

/* SHORTCODE PARA RESALTAR */