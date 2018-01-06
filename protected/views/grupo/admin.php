

<div class="box">
	<div class="box-header">
		<h3 clas="box-title">Admin Grupos</h3>
		<?php $this->widget(
			'booster.widgets.TbButtonGroup',
			array(
				'size' => 'medium',
				'context' => 'primary',
				'buttons' => array(
					array(
						'label' => 'Acciones',
						'items' => array(
							array('label' => 'Crear', 'url' => Yii::app()->createUrl('Grupo/create')),
						)
					),
				),
			)
		); ?>	</div>

	<?php $this->widget('booster.widgets.TbExtendedGridView',array(
	'id'=>'grupo-grid',
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
		'criterio',
		array(
			'name'=>'tipo_activo_id',
			'header'=>'Tipo Activo',
			'value'=>'$data->tipoActivo->nombre',
			'filter'=>CHtml::listData(TipoActivo::model()->findAll(),'id','nombre'),
		),
		'creaUserStamp',
		'creaTimeStamp',
		/*
		'modUserStamp',
		'modTimeStamp',
		*/
	array(
	'class'=>'booster.widgets.TbButtonColumn',
		'template'=>'{update}{delete}'
	),
	),
	)); ?>
</div>


