<?php if(!empty($procesos)){?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th style="text-align: center;">Nombre</th>
                <th style="text-align: center;">Descripcion</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($procesos as $proceso){?>
                <tr>
                    <td style="text-align: center;"><?= $proceso->nombre?></td>
                    <td style="text-align: center;"><?= $proceso->descripcion?></td>
                </tr>
            <?php }?>
        </tbody>
    </table>

<?php }else{?>
    <div class="alert alert-warning alert-dismissible">
<!--        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>-->
        <h4><i class="icon fa fa-info"></i> Informacion!</h4>
            El area seleccionada no tiene procesos relacionados.
    </div>
<?php }?>

