

<div class="box">
	<div class="box-header">
        <div class="box-header with-border">
            <h3 class="box-title">
                Administración de tipo de activo
            </h3>
            <div class="box-tools">
                <div class="btn-group pull-right">
                    <a href="<?= $this->createUrl('create') ?>" class="btn btn-sm btn-success"><i
                                class="fa fa-plus-circle"></i> Crear</a>
                </div>
            </div>
        </div>

	<?php $this->widget('booster.widgets.TbExtendedGridView',array(
	'id'=>'tipo-activo-grid',
	'fixedHeader' => false,
	'headerOffset' => 10,
	// 40px is the height of the main navigation at bootstrap
	'type' => 'striped hover condensed',
	'dataProvider' => $model->search(),
	'responsiveTable' => true,
	'template' => "{summary}\n{items}\n{pager}",
	'selectableRows' => 1,
	'filter' => $model,
	'columns'=>array(
		'nombre',
		'descripcion',
		[
			'header' => 'Confidencialidad',
			'type' => 'raw',
			'value'=>function($data){
				if($data->confidencialidad == TipoActivo::VALOR_SI){
					return "<a onclick=\" \"  class=\"linkCredito\"><i class=\"glyphicon glyphicon-ok\"></i></a>";
				}else{
					return '';
				}
			},
			'filter'=>TipoActivo::$valores,
		],

		[
			'header' => 'Integridad',
			'type' => 'raw',
			'value'=>function($data){
				if($data->integridad == TipoActivo::VALOR_SI){
					return "<a onclick=\" \"  class=\"linkCredito\"><i class=\"glyphicon glyphicon-ok\"></i></a>";
				}else{
					return '';
				}
			},
			'filter'=>TipoActivo::$valores,
		],
		[
			'header' => 'Disponibilidad',
			'type' => 'raw',
			'value'=>function($data){
				if($data->disponibilidad == TipoActivo::VALOR_SI){
					return "<a onclick=\" \"  class=\"linkCredito\"><i class=\"glyphicon glyphicon-ok\"></i></a>";
				}else{
					return '';
				}
			},
			'filter'=>TipoActivo::$valores,
		],
		[
			'header' => 'Trazabilidad',
			'type' => 'raw',
			'value'=>function($data){
				if($data->trazabilidad == TipoActivo::VALOR_SI){
					return "<a onclick=\" \"  class=\"linkCredito\"><i class=\"glyphicon glyphicon-ok\"></i></a>";
				}else{
					return '';
				}
			},
			'filter'=>TipoActivo::$valores,
		],
	array(
	'class'=>'booster.widgets.TbButtonColumn',
		'template'=>'{update}   {delete}',
        'afterDelete' => 'function(link,success,data){ 
                                  var datos = jQuery.parseJSON(data);
                                  if(success){
                                        if(datos.error == 0){
                                            Lobibox.notify(\'success\', {msg: datos.msj }); 
                                        }else{
                                         Lobibox.notify(\'error\', {msg: datos.msj }); 
                                        }
                                  }else{
                                    Lobibox.notify(\'error\', {msg: datos.msj }); 
                                  }
                              }'
	),
	array(
		'class' => 'booster.widgets.TbButtonColumn',
		'template' => '{relaciones}',
		'header' => 'Relaciones',
		'buttons' => array(
			'relaciones' => array(
				'label' => 'Ver Relaciones',
				'icon'=>'fa fa-code-fork',
				'url' => 'Yii::app()->createUrl("/tipoActivo/verRelaciones", array("id"=>$data->id))',

			),
		),
		'htmlOptions' => array('style' => 'width:2%;text-align:center;')
	),
	),
	)); ?>
</div>



