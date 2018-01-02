

<div class="box">
	<div class="box-header">
		<h3 clas="box-title">Admin Amenazas</h3>
		<?php $this->widget(
			'booster.widgets.TbButtonGroup',
			array(
				'size' => 'medium',
				'context' => 'primary',
				'buttons' => array(
					array(
						'label' => 'Acciones',
						'items' => array(
							array('label' => 'Crear', 'url' => Yii::app()->createUrl('Amenaza/create')),
						)
					),
				),
			)
		); ?>	</div>

	<?php $this->widget('booster.widgets.TbExtendedGridView',array(
	'id'=>'amenaza-grid',
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
		'id',
		'nombre',
		'descripcion',
		array(
			'name'=>'confidencialidad',
			'header'=>'Confidencialidad',
			'value'=>'Amenaza::$valores[$data->confidencialidad]',
			'filter'=>Amenaza::$valores,
		),
		array(
			'name'=>'integridad',
			'header'=>'Integridad',
			'value'=>'Amenaza::$valores[$data->integridad]',
			'filter'=>Amenaza::$valores,
		),
		array(
			'name'=>'disponibilidad',
			'header'=>'Disponibilidad',
			'value'=>'Amenaza::$valores[$data->disponibilidad]',
			'filter'=>Amenaza::$valores,
		),
		array(
			'name'=>'trazabilidad',
			'header'=>'Trazabilidad',
			'value'=>'Amenaza::$valores[$data->trazabilidad]',
			'filter'=>Amenaza::$valores,
		),
		array(
			'name'=>'tipo_activo_id',
			'header'=>'Tipo Activo',
			'value'=>'$data->tipoActivo->nombre',
		),
		'creaUserStamp',
		'creaTimeStamp',
	array(
	'class'=>'booster.widgets.TbButtonColumn',
		'template'=>'{update}{delete}'
	),
	),
	)); ?>
</div>



