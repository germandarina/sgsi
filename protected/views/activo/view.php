<?php
$this->breadcrumbs=array(
	'Activos'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Activo','url'=>array('index')),
array('label'=>'Create Activo','url'=>array('create')),
array('label'=>'Update Activo','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Activo','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Activo','url'=>array('admin')),
);
?>

<h1>View Activo #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'nombre',
		'descripcion',
		'tipo_activo_id',
		'personal_id',
		'creaUserStamp',
		'creaTimeStamp',
		'modUserStamp',
		'modTimeStamp',
),
)); ?>
