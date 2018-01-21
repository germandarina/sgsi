<?php
$this->breadcrumbs=array(
	'Nivel De Riesgoses',
);

$this->menu=array(
array('label'=>'Create NivelDeRiesgos','url'=>array('create')),
array('label'=>'Manage NivelDeRiesgos','url'=>array('admin')),
);
?>

<h1>Nivel De Riesgoses</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
