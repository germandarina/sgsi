<div class="box">
	<div class="box-header">
		<h3 class="box-title">Admin Proyectos</h3>
		<?php $this->widget(
			'booster.widgets.TbButtonGroup',
			array(
				'size' => 'medium',
				'context' => 'primary',
				'buttons' => array(
					array(
						'label' => 'Acciones',
						'items' => array(
							array('label' => 'Crear', 'url' => Yii::app()->createUrl('Proyecto/create')),
						)
					),
				),
			)
		); ?>	</div>

	<?php $this->widget('booster.widgets.TbExtendedGridView',array(
	'id'=>'proyecto-grid',
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
			'filter'=>false,
		),
		array(
			'name'=>'usuario_id',
			'header'=>'Usuario',
			'value'=>'$data->usuario != null ? $data->usuario->username : "" ',
			'filter'=>false,
		),
		array(
			'name'=>'id',
			'header'=>'Areas',
			'value'=>'$data->getAreas()',
			'filter'=>false,
		),
		'creaUserStamp',
		'creaTimeStamp',

	array(
	'class'=>'booster.widgets.TbButtonColumn',
		'template'=>'{update}{delete}',
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
	),
	)); ?>
</div>



