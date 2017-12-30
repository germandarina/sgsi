<?php
$this->breadcrumbs=array(
	'Tipo Activos'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List TipoActivo','url'=>array('index')),
array('label'=>'Create TipoActivo','url'=>array('create')),
array('label'=>'Update TipoActivo','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete TipoActivo','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage TipoActivo','url'=>array('admin')),
);
?>

<h1>View TipoActivo #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'nombre',
		'descripcion',
		'confidencialidad',
		'integridad',
		'disponibilidad',
		'trazabilidad',
),
)); ?>
