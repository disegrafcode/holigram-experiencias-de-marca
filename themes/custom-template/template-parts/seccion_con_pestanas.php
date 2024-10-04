<?php
$variables_path = get_template_directory() . '/template-parts/_variables_seccion.php';
include($variables_path);

/* CONTENIDOS DE LAS PESTAÑAS */
$pestanas = $contenido['pestana_contenido'];
$tab_id = "tab_".$key;
/* CONTENIDOS DE LAS PESTAÑAS */
?>
<!-- SECCION CON TABS -->
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
        <div class="row">
            <div class="col-md-12 px-0">
                <ul class="nav nav-underline justify-content-center mb-4" id="<?php echo $tab_id ?>" role="tablist">
                    <?php $contador_items=0; ?>
                    <?php foreach($pestanas AS $key=>$pestana): ?>
                        <?php if(!$pestana['ocultar_pestana']): ?>
                        <!-- titulo del las pestaña -->
                        <li class="nav-item" role="presentation">
                            <a
                                class="nav-link text-dark <?php echo ($contador_items==0)?"active":"" ?>"
                                id="<?php echo $tab_id."_pestana_".$key ?>" 
                                data-bs-toggle="pill"                            
                                data-bs-target="#<?php echo $tab_id."_contenido_".$key ?>"
                                type="button"
                                role="tab"
                                aria-controls="<?php echo $tab_id."_contenido_".$key ?>"
                                aria-selected="true"
                                >
                                <?php echo ($pestana['nombre_de_la_pestana'])?$pestana['nombre_de_la_pestana']:"Sin Título" ?>
                            </a>
                        </li>
                        <!-- titulo del las pestaña -->
                        <?php $contador_items++ ?>
                        <?php endif ?>
                    <?php endforeach ?>
                </ul>
                <div class="tab-content" id="<?php echo $tab_id."-content" ?>">
                    <?php $contador_items=0; ?>       
                    <?php foreach($pestanas AS $key=>$pestana): ?>
                        <?php if(!$pestana['ocultar_pestana']): ?>
                        <!-- contenido tab -->
                        <div class="tab-pane fade <?php echo ($contador_items==0)?"active show":"" ?>"
                            id="<?php echo $tab_id."_contenido_".$key ?>"
                            role="tabpanel"
                            aria-labelledby="<?php echo $tab_id."_pestana_".$key ?>"
                            tabindex="0"
                            >
                        <?php
                        $file_section=get_template_directory().'/template-parts/'.$pestana['acf_fc_layout'].'.php';
                        if(file_exists($file_section))
                        {
                            include $file_section;
                        }
                        else
                        {
                            echo "No se encontró plantilla.";
                        }
                        ?>
                        </div>
                        <!-- contenido tab -->
                        <?php $contador_items++ ?>
                        <?php endif ?>
                    <?php endforeach ?>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- SECCION CON TABS -->