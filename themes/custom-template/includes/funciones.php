<?php
/* FORMATEA CODIGO */
function dd($data){
    highlight_string("<?php\n " . var_export($data, true) . "?>");
    echo '<script>document.getElementsByTagName("code")[0].getElementsByTagName("span")[1].remove() ;document.getElementsByTagName("code")[0].getElementsByTagName("span")[document.getElementsByTagName("code")[0].getElementsByTagName("span").length - 1].remove() ; </script>';
}
/* FORMATEA CODIGO */

/* REMUEVE LA ETIQUETA DE PARRAFOS EN UN STRING */
function remove_paragraph_tags($string) {
    return str_replace(array('<p>', '</p>'), '', $string);
}
/* REMUEVE LA ETIQUETA DE PARRAFOS EN UN STRING */
  
/* GENERA IDS ÚNICOS */
function generar_id_unico() {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $longitud = 9;
    $id_unico = '';
    for ($i = 0; $i < $longitud; $i++) {
        $id_unico .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $id_unico;
}
/* GENERA IDS ÚNICOS */

/* RECORTA TEXTO */
function recortar_string($string, $length = 100) {
    // Verifica si la longitud del string es mayor que la longitud deseada
    if(strlen($string) > $length) {
        // Recorta el string a la longitud deseada
        $string = substr($string, 0, $length);
        // Busca la última ocurrencia de un espacio para asegurarse de no cortar una palabra
        $last_space = strrpos($string, ' ');
        if($last_space !== false) {
            // Recorta el string hasta el último espacio
            $string = substr($string, 0, $last_space);
        }
        // Añade puntos suspensivos al final del string recortado
        $string .= '[...]';
    }
    return $string;
}
/* RECORTA TEXTO */