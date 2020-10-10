<?php if(!empty($arrayControles)){ ?>
    <div class="table-responsive ">
        <table class="table table-bordered">
            <thead>
            <tr style="background-color: rgba(0, 214, 124, 0.62)">
                <th>Control</th>
                <th>Valoracion</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($arrayControles as $fila){?>
                <tr>
                    <td><?= $fila->control->numeracion ?> - <?= $fila->control->nombre?></td>
                    <td><?= $fila->valor ?></td>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </div>

<?php } else {?>

    <div class="alert alert-danger" role="alert">
        ESTE ACTIVO NO POSEE CONTROLES EN RIESGO
    </div>
<?php }?>
