

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">
            Personal
        </h3>
        <div class="box-tools">
            <div class="btn-group pull-right">
                <a href="<?= $this->createUrl('create') ?>" class="btn btn-sm btn-success"><i
                            class="fa fa-plus-circle"></i> Crear</a>
            </div>
        </div>
    </div>

	<?php
		if(Yii::app()->user->model->isAdmin() || Yii::app()->user->model->isGerencial() || Yii::app()->user->model->isAuditor()) {
			$this->widget('booster.widgets.TbExtendedGridView',array(
				'id'=>'personal-grid',
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
					'apellido',
					'nombre',
					'dni',
					'telefono',
					array(
						'name'=>'area_id',
						'header'=>'Area',
						'value'=>'$data->area->nombre',
					),
					array(
						'name'=>'proceso_id',
						'header'=>'Proceso',
						'value'=>'$data->proceso->nombre',
					),
					array(
						'class'=>'booster.widgets.TbButtonColumn',
						'template'=>'{update}{delete}',
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
				),
			));
	}?>
</div>



