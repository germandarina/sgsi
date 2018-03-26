
<div class="box">
    <?php foreach ($areas as $area){?>
    <h3 style="text-align: center;"> Area - <?= $area['nombre_area']?></h3>
    <div class="table-responsive">
        <table class="table">
            <thead style="background-color: rgba(0, 136, 168, 0.54);">
                <tr>
                    <th>Activo</th>
                    <th>Valor</th>
                    <th>Proceso</th>
                </tr>
            </thead>
            <tbody>
                <?php $resultados= Analisis::getActivosAfectadosPorArea($area['analisis_id'],$area['area_id']);?>
                <?php foreach ($resultados as $resultado){?>
                    <tr>
                        <td><?= $resultado['nombre_activo'] ?></td>
                        <td><?= GrupoActivo::$arrayValores[$resultado['valor_activo']]?></td>
                        <td><?= $resultado['nombre_proceso'] ?></td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
    <?php }?>
</div>
