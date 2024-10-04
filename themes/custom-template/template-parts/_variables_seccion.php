<?php 
$opciones_de_seccion = $contenido['opciones_de_seccion'];
if($opciones_de_seccion['ocultar_contenido']) return;
$section_id = ($contenido['seccion_id'])?$contenido['seccion_id']:"section_".$key;
$clase_personalizada = $opciones_de_seccion['clase_personalizada'];
$template_name = $contenido['acf_fc_layout'];

/* RELLENO SUPERIOR E INFERIOR DE LAS SECCIONES */
$inicial_class = "py-5";
$sin_relleno_superior = $opciones_de_seccion['sin_relleno_superior'];
$sin_relleno_inferior = $opciones_de_seccion['sin_relleno_inferior'];
if ($sin_relleno_superior && $sin_relleno_inferior) {
  $inicial_class = "" ;// No padding
} elseif ($sin_relleno_superior && !$sin_relleno_inferior) {
  $inicial_class = "pb-5"; // Solo bottom padding
} elseif (!$sin_relleno_superior && $sin_relleno_inferior) {
  $inicial_class = "pt-5"; // Solo top padding
}
/* RELLENO SUPERIOR E INFERIOR DE LAS SECCIONES */

$style = "";
/* COLOR DE FONDO E IMAGEN DE FONDO */
$ancho_completo_seccion = $opciones_de_seccion['seccion_ancho_completo'];
$color_de_fondo_seccion = $opciones_de_seccion['color_de_fondo'];
if($color_de_fondo_seccion) $style .= "background-color:".$color_de_fondo_seccion.";";
/* COLOR DE FONDO E IMAGEN DE FONDO */

/* IMAGEN DE FONDO */
$imagen_de_fondo_desktop = $opciones_de_seccion['imagen_de_fondo_desktop'];
$imagen_de_fondo_mobile = $opciones_de_seccion['imagen_de_fondo_mobile'];

if(!$imagen_de_fondo_desktop && $imagen_de_fondo_mobile)
{
    $imagen_de_fondo_desktop = $imagen_de_fondo_mobile;
}

if(!$imagen_de_fondo_mobile && $imagen_de_fondo_desktop)
{
    $imagen_de_fondo_mobile = $imagen_de_fondo_desktop;
}
/* IMAGEN DE FONDO */

if($style)
{
    $style = "style='".$style."'";
}