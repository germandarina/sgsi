<?php
$this->breadcrumbs=array(
	'Grupos'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Grupo','url'=>array('index')),
array('label'=>'Create Grupo','url'=>array('create')),
array('label'=>'Update Grupo','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Grupo','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Grupo','url'=>array('admin')),
);
?>

<h1>View Grupo #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'nombre',
		'criterio',
		'tipo_activo_id',
		'creaUserStamp',
		'creaTimeStamp',
		'modUserStamp',
		'modTimeStamp',
),
)); ?>
