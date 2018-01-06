<?php
$this->breadcrumbs=array(
	'Analisises',
);

$this->menu=array(
array('label'=>'Create Analisis','url'=>array('create')),
array('label'=>'Manage Analisis','url'=>array('admin')),
);
?>

<h1>Analisises</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
