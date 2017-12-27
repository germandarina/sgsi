<style type="text/css">
	.grid-view tr:hover td {
          background-color: #ffff99;
    }
</style>
<?php
$this->widget(
	'booster.widgets.TbBreadcrumbs',
	array(
		'links' => array('Usuarios' => array('admin'), 'Actualizar'),
	)
);
 ?>
<div class="box">

	<div class="box-header with-border">
		<h3>Editar Usuario <?= $model->username ?></h3>
	</div>

	<?php echo $this->renderPartial('_form', array('model'=>$model,"perfiles"=>$perfiles)); ?>
</div>