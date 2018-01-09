
<?php
$this->widget(
	'booster.widgets.TbBreadcrumbs',
	array(
		'links' => array('Analisis' => array('admin'), 'Actualizar'),
	)
);
 ?>
<div class="box">

	<div class="box-header with-border">
		<h3>Editar Analisis</h3>
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
						array('label' => 'Asociaciones',
							'content' => $this->renderPartial('asociaciones', array('model'=>$model,'grupo_activo'=>$grupo_activo), true),
							'active' => true,
						),
                        array('label' => 'Dependencias',
                            'content' => $this->renderPartial('dependencias', array('model'=>$model,'dependencia'=>$dependencia), true),
                        ),
					),
				)
			);
			?>
		</div>
	</div>
</div>


