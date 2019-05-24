<?php if(!empty($activos)){?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th style="text-align: center;">Nombre</th>
                <th style="text-align: center;">Descripcion</th>
                <th style="text-align: center;">Tipo Activo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($activos as $activo){?>
                <tr>
                    <td style="text-align: center;"><?= $activo->nombre?></td>
                    <td style="text-align: center;"><?= $activo->descripcion?></td>
                    <td style="text-align: center;"><?= $activo->tipoActivo->nombre ?></td>
                </tr>
            <?php }?>
        </tbody>
    </table>

<?php }else{?>
    <div class="alert alert-warning alert-dismissible">
<!--        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>-->
        <h4><i class="icon fa fa-info"></i> Informacion!</h4>
            El proceso seleccionado no tiene activos relacionados.
    </div>
<?php }?>

