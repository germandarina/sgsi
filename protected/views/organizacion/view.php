<?php
$this->breadcrumbs=array(
	'Organizacions'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Organizacion','url'=>array('index')),
array('label'=>'Create Organizacion','url'=>array('create')),
array('label'=>'Update Organizacion','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Organizacion','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Organizacion','url'=>array('admin')),
);
?>

<h1>View Organizacion #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'nombre',
		'direccion',
		'creaUserStamp',
		'creaTimeStamp',
		'modUserStamp',
		'modTimeStamp',
),
)); ?>
