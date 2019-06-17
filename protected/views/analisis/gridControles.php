<style>
	.alert-blue{
		background-color: #0070a6e8;
		color: white;
	}
    .glyphicon.glyphicon-pencil {
		color: white !important;
	}
</style>
<?php

$this->widget('booster.widgets.TbExtendedGridView', array(
	'htmlOptions'=>array('class'=>'gridControles'),
	'dataProvider' => $controles->searchValoracion(),
	'template' => "{items}",
    'id'=>'controles-grid',
    //'selectableRows' => 0,
	'rowCssClassExpression'=>'"alert-blue"',
	'columns' => array(
		array(
			'name'=>'numeracion',
			'header'=>'Numero',
			'value'=>'$data->numeracion',
		),
		array(
			'name'=>'nombre',
			'header'=>'Nombre Control',
			'value'=>'$data->nombre',
		),
		array(
			'name' => 'descripcion',
			'header' => 'Descripcion Control',
			'value' => '$data->descripcion',
		),
		array( 'name'=>'fecha_valor_control',
			'header'=>'Fecha Valoracion',
			'value'=>function($data)use($analisis_id,$grupo_activo_id,$analisis_amenaza_id){
				return $data->getFechaValorControl($analisis_id,$grupo_activo_id,$analisis_amenaza_id);
			},
			'filter'=>false,
		),
		array( 'name'=>'valor_control',
			'header'=>'Valor Control',
			'value'=>function($data)use($analisis_id,$grupo_activo_id,$analisis_amenaza_id){
				return $data->getValorControl($analisis_id,$grupo_activo_id,$analisis_amenaza_id);
			},
			'filter'=>false,
		),
        [
            'header' => 'Accion',
            'type' => 'raw',
            'value' => '"<a style=\"cursor: pointer;\" onclick=\"valorarControl($data->id) \" title=\"Presione para Valorar\" class=\"linkCredito\"><i class=\"glyphicon glyphicon-pencil\"></i></a>"',
            'htmlOptions'=>['style'=>'width:5%;'],
        ]
	),
));

?>


