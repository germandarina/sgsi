<?php
$this->breadcrumbs=array(
	'Areas'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Area','url'=>array('index')),
array('label'=>'Create Area','url'=>array('create')),
array('label'=>'Update Area','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Area','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Area','url'=>array('admin')),
);
?>

<h1>View Area #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'nombre',
		'descripcion',
		'creaUserStamp',
		'creaTimeStamp',
		'modUserStamp',
		'modTimeStamp',
),
)); ?>
