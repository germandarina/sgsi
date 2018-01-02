<?php
$this->breadcrumbs=array(
	'Controls'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Control','url'=>array('index')),
array('label'=>'Create Control','url'=>array('create')),
array('label'=>'Update Control','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Control','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Control','url'=>array('admin')),
);
?>

<h1>View Control #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'nombre',
		'descripcion',
		'numeracion',
		'vulnerabilidad_id',
		'creaUserStamp',
		'creaTimeStamp',
		'modUserStamp',
		'modTimeStamp',
),
)); ?>
