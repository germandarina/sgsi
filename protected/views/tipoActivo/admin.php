

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
		//		array(
//			'name'=>'confidencialidad',
//			'header'=>'Confidencialidad',
//			'value'=>'TipoActivo::$valores[$data->confidencialidad]',
//			'filter'=>TipoActivo::$valores,
//		),
//		array(
//			'name'=>'integridad',
//			'header'=>'Integridad',
//			'value'=>'TipoActivo::$valores[$data->integridad]',
//			'filter'=>TipoActivo::$valores,
//		),
//		array(
//			'name'=>'disponibilidad',
//			'header'=>'Disponibilidad',
//			'value'=>'TipoActivo::$valores[$data->disponibilidad]',
//			'filter'=>TipoActivo::$valores,
//		),
//		array(
//			'name'=>'trazabilidad',
//			'header'=>'Trazabilidad',
//			'value'=>'TipoActivo::$valores[$data->trazabilidad]',
//			'filter'=>TipoActivo::$valores,
//		),
		'creaUserStamp',
		'creaTimeStamp',
	array(
	'class'=>'booster.widgets.TbButtonColumn',
		'template'=>'{update}{delete}'
	),
	array(
		'class' => 'booster.widgets.TbButtonColumn',
		'template' => '{relaciones}',
		'header' => 'Relaciones',
		'buttons' => array(
			'relaciones' => array(
				'label' => 'Ver Relaciones',
				'icon'=>'fa fa-code-fork',
				//'imageUrl' => Yii::app()->request->baseUrl . '/images/recibo.png',
				'url' => 'Yii::app()->createUrl("/tipoActivo/verRelaciones", array("id"=>$data->id))',
//				'options' => array(
//					'class' => 'imagenRecibo',
//					//'style' => 'padding-left: 8px;',
//				),
//				'visible' => function ($row, $data) use ($esArqueo) {
//					/*if($esArqueo) {
//						return false;
//					}
//				*/
//					return ($data->estado == OrdenPedido::ESTADO_PAGADA && $data->realizarNotaCredito == 1) ? true : false;
//				},
			),
		),
		'htmlOptions' => array('style' => 'width:2%;text-align:center;')
	),
//	[
//		'header' => 'Relaciones',
//		'type' => 'raw',
//		'value' => '"<a onclick=\"mostrarDetalleOrdenCompra($data->id) \" title=\"Ver Relaciones\" class=\"linkCredito\"><i class=\"fa fa-code-fork\" aria-hidden=\"true\"></i></a>"',
//	]
	),
	)); ?>
</div>



