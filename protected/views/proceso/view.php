<?php
$this->breadcrumbs=array(
	'Procesos'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Proceso','url'=>array('index')),
array('label'=>'Create Proceso','url'=>array('create')),
array('label'=>'Update Proceso','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Proceso','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Proceso','url'=>array('admin')),
);
?>

<h1>View Proceso #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'nombre',
		'descripcion',
		'area_id',
		'creaUserStamp',
		'creaTimeStamp',
		'modUserStamp',
		'modTimeStamp',
),
)); ?>
