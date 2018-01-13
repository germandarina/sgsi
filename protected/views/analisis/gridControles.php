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
			'header'=>'Nombre',
			'value'=>'$data->nombre',
		),
		array(
			'name' => 'descripcion',
			'header' => 'Descripcion',
			'value' => '$data->descripcion',
		),
        [
            'header' => 'Accion',
            'type' => 'raw',
            'value' => '"<a onclick=\"valorarControl($data->id) \" title=\"Presione para Valorar\" class=\"linkCredito\"><i class=\"glyphicon glyphicon-pencil\"></i></a>"',
            'htmlOptions'=>['style'=>'width:5%;']
        ]
	),
));

?>


