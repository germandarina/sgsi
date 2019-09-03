<script>
	$(function () {
		$("#analisis-grid_c8").empty().html('Crear Plan Tratamiento');
		$("#analisis-grid_c9").empty().html('Ver Planes Tratamiento');
	});
</script>

<div class="box">
	<div class="box-header">
		<h3 class="box-title">Admin Analisis</h3>
		<?php $this->widget(
			'booster.widgets.TbButtonGroup',
			array(
				'size' => 'medium',
				'context' => 'primary',
				'buttons' => array(
					array(
						'label' => 'Acciones',
						'items' => array(
							array('label' => 'Crear', 'url' => Yii::app()->createUrl('Analisis/create')),
						)
					),
				),
			)
		); ?>
    </div>
	<?php
        $this->widget('booster.widgets.TbExtendedGridView',array(
            'id'=>'analisis-grid',
            'fixedHeader' => false,
            'headerOffset' => 10,
            // 40px is the height of the main navigation at bootstrap
            'type' => 'striped hover condensed',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => "{summary}\n{items}\n{pager}",
            'selectableRows' => 1,
            'filter' => $model,
            'columns'=>array(
                'nombre',
                'descripcion',
                array(
                    'name'=>'fecha',
                    'header'=>'Fecha',
                    'value'=>'Utilities::ViewDateFormat($data->fecha)',
                ),
                array(
                    'name'=>'personal_id',
                    'header'=>'Personal',
                    'value'=>'$data->getPersonal()',
                ),
                array(
                    'class'=>'booster.widgets.TbButtonColumn',
                    'template'=>'{update} {view} {delete}',
                    'afterDelete' => 'function(link,success,data){ 
                                  var datos = jQuery.parseJSON(data);
                                  if(success){
                                        if(datos.error == 0){
                                            Lobibox.notify(\'success\', {msg: datos.msj }); 
                                        }else{
                                         Lobibox.notify(\'error\', {msg: datos.msj }); 
                                        }
                                  }else{
                                    Lobibox.notify(\'error\', {msg: datos.msj }); 
                                  }
                              }'
                ),
                array('class' => 'booster.widgets.TbButtonColumn',
                    'template' => '{crear}  {ver}',
                    'buttons' => array(
                        'crear' => array(
                            'header'=>'Crear',
                            'title'=>'Crear',
                            'label' => 'Crear Plan de Tratamiento',
                            'url' => 'Yii::app()->createUrl("/plan/create", array("analisis_id"=>$data->id))',
                            'icon' => 'fa fa-plus-square',
                        ),
                        'ver' => array(
                            'label' => 'Ver/Actualizar Planes de Tratamiento',
                            'url' => 'Yii::app()->createUrl("/plan/verPlanes", array("id"=>$data->id))',
                            'visible' => '$data->tienePlanDeTratamiento()', //  SI NO TIENE PLAN NO MOSTRAR EL ICONO;
                            'icon' => 'fa fa-eye',
                        ),
                    ),
                    ),
            ),
        ));
	 ?>

</div>



