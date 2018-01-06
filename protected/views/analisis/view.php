<?php
$this->breadcrumbs=array(
	'Analisises'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Analisis','url'=>array('index')),
array('label'=>'Create Analisis','url'=>array('create')),
array('label'=>'Update Analisis','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Analisis','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Analisis','url'=>array('admin')),
);
?>

<h1>View Analisis #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'nombre',
		'descripcion',
		'fecha',
		'personal_id',
		'creaUserStamp',
		'creaTimeStamp',
		'modUserStamp',
		'modTimeStamp',
),
)); ?>
