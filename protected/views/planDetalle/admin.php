<style>
	.alert-blue{
		background-color: #0070a6e8 !important;
		color: white;
	}
	.glyphicon.glyphicon-pencil {
		color: white !important;
	}
</style>
<script>

</script>
	<?php $this->widget('booster.widgets.TbExtendedGridView',array(
		'htmlOptions'=>array('class'=>'gridControles'),
		'id'=>'plan-detalle-grid',
		'rowCssClassExpression'=>'"alert-blue"',
		'dataProvider' => $model->search(),
		'template' => "{items}",
		'columns'=>array(
		[
			'name'=>'analisis_control_id',
			'header'=>'Control',
			'value'=>'$data->analisisControl->control->nombre',
		],
		[
			'name'=>'analisis_control_id',
			'header'=>'Valor',
			'value'=>'$data->analisisControl->valor'
		],
		[
			'name'=>'fecha_posible_inicio',
			'header'=>'Fecha Posible Inicio',
			'value'=>'Utilities::ViewDateFormat($data->fecha_posible_inicio)',
		],
		[
			'name'=>'fecha_posible_fin',
			'header'=>'Fecha Posible Fin',
			'value'=>'Utilities::ViewDateFormat($data->fecha_posible_fin)',
		],
		[
			'name'=>'fecha_real_inicio',
			'header'=>'Fecha Real Inicio',
			'value'=>'Utilities::ViewDateFormat($data->fecha_real_inicio)',
		],
		[
			'name'=>'fecha_real_fin',
			'header'=>'Fecha Real Fin',
			'value'=>'Utilities::ViewDateFormat($data->fecha_real_fin)',
		],
		'creaUserStamp',
		'creaTimeStamp',
		[
			'header' => 'Accion',
			'type' => 'raw',
			'value' => '"<a style=\"cursor: pointer;\" onclick=\"levantarModalPlanDetalle(event,$data->id) \" title=\"Presione para Valorar\" class=\"linkCredito\"><i class=\"glyphicon glyphicon-pencil\"></i></a>"',
			'htmlOptions'=>['style'=>'width:5%;'],
		]
	),
	)); ?>

