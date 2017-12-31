<?php
$this->breadcrumbs=array(
	'Amenazas'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Amenaza','url'=>array('index')),
array('label'=>'Create Amenaza','url'=>array('create')),
array('label'=>'Update Amenaza','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Amenaza','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Amenaza','url'=>array('admin')),
);
?>

<h1>View Amenaza #<?php echo $model->id; ?></h1>

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
		'creaUserStamp',
		'creaTimeStamp',
		'modUserStamp',
		'modTimeStamp',
),
)); ?>
