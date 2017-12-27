<div class="box-body">
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
  'id'=>'user-form',
  'enableAjaxValidation'=>false,
  'type' => 'horizontal'
)); ?>
    <h1>Cambiar Contraseña Usuario <?php echo $model->username; ?></h1>
    <p class="help-block">Campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>
            <div class="row">
                <div class="col-sm-6">
                    <?php echo $form->passwordFieldGroup($model,'old_password',array('class'=>'col-sm-6','maxlength'=>255)); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?php echo $form->passwordFieldGroup($model,'new_password',array('class'=>'col-sm-6','maxlength'=>255)); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?php echo $form->passwordFieldGroup($model,'repeat_password',array('class'=>'col-sm-6','maxlength'=>255)); ?>
                </div>
            </div>
            

    
    <div class="box-footer">
        <?php $this->widget('booster.widgets.TbButton', array(
      'buttonType'=>'submit',
      'context'=>'primary',
      'label'=>$model->isNewRecord ? 'Crear' : 'Guardar Cambios',
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