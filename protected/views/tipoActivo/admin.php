

<div class="box">
	<div class="box-header">
		<h3 clas="box-title">Admin Tipo Activos</h3>
		<?php $this->widget(
			'booster.widgets.TbButtonGroup',
			array(
				'size' => 'medium',
				'context' => 'primary',
				'buttons' => array(
					array(
						'label' => 'Acciones',
						'items' => array(
							array('label' => 'Crear', 'url' => Yii::app()->createUrl('TipoActivo/create')),
						)
					),
				),
			)
		); ?>	</div>

	<?php $this->widget('booster.widgets.TbExtendedGridView',array(
	'id'=>'tipo-activo-grid',
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
		'confidencialidad',
		'integridad',
		'disponibilidad',
		/*
		'trazabilidad',
		*/
	array(
	'class'=>'booster.widgets.TbButtonColumn',
	),
	),
	)); ?>
</div>



