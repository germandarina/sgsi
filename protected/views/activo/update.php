
<?php
$this->widget(
	'booster.widgets.TbBreadcrumbs',
	array(
		'links' => array('Activos' => array('admin'), 'Actualizar'),
	)
);
 ?>
<div class="box">

	<div class="box-header with-border">
		<h3>Editar Activo</h3>
	</div>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
<div class="box">
    <div class="box-body">
        <div class="col-md-12">
            <br>
            <?php $this->widget(
                'booster.widgets.TbTabs',
                array(
                    'type' => 'tabs', // 'tabs' or 'pills'
                    'htmlOptions' => ['class' => 'nav-tabs-custom'],
                    'tabs' => array(
                        array('label' => 'Areas y Procesos',
                            'content' => $this->renderPartial('procesos', array('activo_area'=>$activo_area,'model'=>$model), true),
                            'active' => true,
                        ),
                    ),
                )
            );
            ?>
        </div>
    </div>
</div>
