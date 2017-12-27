<div class="box-body">
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
	'type' => 'horizontal'
)); ?>

    <p class="help-block">Campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>
            <div class="row">
                <div class="col-sm-6">
                    <?php echo $form->textFieldGroup($model,'username',array('class'=>'col-sm-6','maxlength'=>50)); ?>
                </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <?php 
                  if(!$model->isNewRecord)
                    $value = array_keys(Yii::app()->authManager->getAuthAssignments($model->id));
                  else
                    $value = array();
                ?>
                <?php echo $form->select2Group(
                $model,
                'perfil',
                array(
                    'wrapperHtmlOptions' => array(
                        'class' => 'col-sm-9 input-group-sm',
                    ),
                    'widgetOptions' => array(
                        'asDropDownList' => true,
                        'data' => $perfiles,
                        'htmlOptions' => [
                            'multiple'=>'multiple'],
                        'options' => [
                            'minimumResultsForSearch' => 10,
                            'placeholder' => '--Seleccione--',

                        ],
                    ),

                )
                );
                ?>
              </div>
            </div>
            <br /><br />
            <fieldset><legend>Jornada Laboral</legend>
            <div class="row">
                <div class="col-sm-6">
                    <?php echo 
                       $form->select2Group(
                              $model,
                              'diaDesde',
                              array(
                                  'wrapperHtmlOptions' => array(
                                      'class' => 'col-sm-9 input-group-sm',
                                  ),
                                  'widgetOptions' => array(
                                      'asDropDownList' => true,
                                      'data' => $model->getTypeOptions(),
                                      'options' => [
                                          'minimumResultsForSearch' => 10,
                                          'placeholder' => '--Seleccione--',

                                      ],
                                  ),

                              )
                              ); ?>
                </div>
                 <div class="col-sm-6">
                 <?php echo 
                       $form->select2Group(
                              $model,
                              'diaHasta',
                              array(
                                  'wrapperHtmlOptions' => array(
                                      'class' => 'col-sm-9 input-group-sm',
                                  ),
                                  'widgetOptions' => array(
                                      'asDropDownList' => true,
                                      'data' => $model->getTypeOptions(),
                                      'options' => [
                                          'minimumResultsForSearch' => 10,
                                          'placeholder' => '--Seleccione--',

                                      ],
                                  ),

                              )
                              ); ?>
                </div>
            </div><br>
            <div class="row">
                <div class="col-sm-6">
                    <label class="col-sm-3 control-label">Hora Desde</label>
                     <?php 
                          $this->widget(
                             'booster.widgets.TbTimePicker',
                             array(
                                 'model' => $model,
                                 'attribute' => 'horaDesde',
                                 'options' => array(
                                     'showMeridian' => false
                                 ),
                                 'wrapperHtmlOptions' => array('class' => 'col-md-3'),
                             )
                            );
                    ?>
                </div>
                <div class="col-sm-6">
                   <label class="col-sm-3 control-label">Hora Hasta</label>
                   <?php 
                        $this->widget(
                               'booster.widgets.TbTimePicker',
                               array(
                                   'model' => $model,
                                   'attribute' => 'horaHasta',
                                   'options' => array(
                                       'showMeridian' => false
                                   ),
                                   'wrapperHtmlOptions' => array('class' => 'col-md-3'),
                               )
                              );
                ?>
                </div>
            </div><br>
            <div class="row">
              <div class="col-sm-6">
                <?php echo
                  $form->select2Group(
                              $model,
                              'estado',
                              array(
                                  'wrapperHtmlOptions' => array(
                                      'class' => 'col-sm-9 input-group-sm',
                                  ),
                                  'widgetOptions' => array(
                                      'asDropDownList' => true,
                                      'data' => $model->getTypeOptionsHabilitar(),
                                      'options' => [
                                          'minimumResultsForSearch' => 10,
                                          'placeholder' => '--Seleccione--',

                                      ],
                                  ),

                              )
                              ); ?>
              </div>
            </div>
    <br />
    <?php echo $this->renderPartial('_usuarioEmpresasSucursales', array('model'=>$model,'form'=>$form)); ?>        
    
    <div class="box-footer">
        <?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
			'size'=>'small'
		)); ?>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
			//'buttonType'=>'submit',
			'label'=> 'Cancelar',
			'size' => 'small',
			'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
		)); ?>
    </div>
    <?php $this->endWidget(); ?>

</div>