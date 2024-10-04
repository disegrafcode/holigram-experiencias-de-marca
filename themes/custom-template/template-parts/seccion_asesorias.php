<?php
$columnas = $pestana['contenido_asesorias'];
if(!$columnas) exit();
$numero_columnas = ($pestana['columnas'])?$pestana['columnas']:4;
?>
<div class="container">
    <div class="row px-md-0 px-2">
        <?php foreach($columnas AS $key=>$columna): ?>
        <div class="col-md-<?php echo $numero_columnas ?> px-md-4 px-1 mb-md-0 mb-5">
            <div class="item">
                <!-- imagen -->
                <?php if($columna['imagen']): ?>
                <img src="<?php echo $columna['imagen'] ?>" alt="icon" width="78"
                    height="78" class="mb-3">
                <?php endif ?>
                <!-- imagen -->
                 <!-- titulo -->
                 <?php if($columna['titulo']): ?>      
                <h2 class="text-primary"><?php echo $columna['titulo'] ?></h2>
                <?php endif ?>
                <!-- titulo -->
                 <!-- descripción -->
                 <?php if($columna['descripcion']): ?>
                    <div class="text-container">
                        <?php echo $columna['descripcion'] ?>
                    </div>
                <?php endif ?>
                <!-- descripción -->
            </div>
        </div>
        <?php endforeach ?>
    </div>
</div>