
<?php
$this->widget(
	'booster.widgets.TbBreadcrumbs',
	array(
		'links' => array('Areas' => array('admin'), 'Actualizar'),
	)
);
 ?>
<div class="box">

	<div class="box-header with-border">
		<h3>Editar Area</h3>
	</div>

	<?php echo $this->renderPartial('_form', array('model'=>$model,'proceso'=>$proceso)); ?>
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
                        array('label' => 'Procesos',
                            'content' => $this->renderPartial('procesos', array('proceso'=>$proceso), true),
                            'active' => true,
                        ),
                    ),
                )
            );
            ?>
        </div>
    </div>
</div>