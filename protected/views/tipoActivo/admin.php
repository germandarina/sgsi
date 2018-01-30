

<div class="box">
	<div class="box-header">
		<h3 clas="box-title">Admin Tipo de Activos</h3>
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
		'nombre',
		'descripcion',
		[
			'header' => 'Confidencialidad',
			'type' => 'raw',
			'value'=>function($data){
				if($data->confidencialidad == TipoActivo::VALOR_SI){
					return "<a onclick=\" \" title=\"Presione para ver\" class=\"linkCredito\"><i class=\"glyphicon glyphicon-ok\"></i></a>";
				}else{
					return '';
				}
			},
			'filter'=>TipoActivo::$valores,
		],

		[
			'header' => 'Integridad',
			'type' => 'raw',
			'value'=>function($data){
				if($data->integridad == TipoActivo::VALOR_SI){
					return "<a onclick=\" \" title=\"Presione para ver\" class=\"linkCredito\"><i class=\"glyphicon glyphicon-ok\"></i></a>";
				}else{
					return '';
				}
			},
			'filter'=>TipoActivo::$valores,
		],
		[
			'header' => 'Disponibilidad',
			'type' => 'raw',
			'value'=>function($data){
				if($data->disponibilidad == TipoActivo::VALOR_SI){
					return "<a onclick=\" \" title=\"Presione para ver\" class=\"linkCredito\"><i class=\"glyphicon glyphicon-ok\"></i></a>";
				}else{
					return '';
				}
			},
			'filter'=>TipoActivo::$valores,
		],
		[
			'header' => 'Trazabilidad',
			'type' => 'raw',
			'value'=>function($data){
				if($data->trazabilidad == TipoActivo::VALOR_SI){
					return "<a onclick=\" \" title=\"Presione para ver\" class=\"linkCredito\"><i class=\"glyphicon glyphicon-ok\"></i></a>";
				}else{
					return '';
				}
			},
			'filter'=>TipoActivo::$valores,
		],
		'creaUserStamp',
		'creaTimeStamp',
	array(
	'class'=>'booster.widgets.TbButtonColumn',
		'template'=>'{update}{delete}',
		'afterDelete' => 'function(link,success,data) { if (success && data) Lobibox.notify(\'info\', {msg: data }); }'
	),
	array(
		'class' => 'booster.widgets.TbButtonColumn',
		'template' => '{relaciones}',
		'header' => 'Relaciones',
		'buttons' => array(
			'relaciones' => array(
				'label' => 'Ver Relaciones',
				'icon'=>'fa fa-code-fork',
				'url' => 'Yii::app()->createUrl("/tipoActivo/verRelaciones", array("id"=>$data->id))',

			),
		),
		'htmlOptions' => array('style' => 'width:2%;text-align:center;')
	),
	),
	)); ?>
</div>



