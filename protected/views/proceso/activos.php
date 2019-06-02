
        <?php
        $this->widget('booster.widgets.TbExtendedGridView',array(
            'id'=>'area-grid',
            'fixedHeader' => false,
            'headerOffset' => 10,
            // 40px is the height of the main navigation at bootstrap
            'type' => 'striped hover condensed',
            'dataProvider' => $activo->searchPorArea(),
            'responsiveTable' => true,
            'template' => "{summary}\n{items}\n{pager}",
            'selectableRows' => 1,
           // 'filter' => $model,
            'columns'=>array(
                [
                    'name'=>'nombre',
                    'header'=>'Nombre',
                    'value' =>'$data->nombre',
                ],
                'descripcion',
            ),
        ));

        ?>
