<?php
$this->breadcrumbs=array(
	'Vulnerabilidads'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Vulnerabilidad','url'=>array('index')),
array('label'=>'Create Vulnerabilidad','url'=>array('create')),
array('label'=>'Update Vulnerabilidad','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Vulnerabilidad','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Vulnerabilidad','url'=>array('admin')),
);
?>

<h1>View Vulnerabilidad #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'nombre',
		'descripcion',
		'amenaza_id',
		'creaUserStamp',
		'creaTimeStamp',
		'modUserStamp',
		'modTimeStamp',
),
)); ?>
