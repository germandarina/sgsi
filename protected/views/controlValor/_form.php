<div class="box-body">
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'control-valor-form',
	'enableAjaxValidation'=>false,
	'type' => 'horizontal'
)); ?>

    <p class="help-block">Campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($controlValor); ?>

            <?php echo $form->datepickerGroup($controlValor, 'fecha', [
                'widgetOptions' => [
                    'options' => ['language' => 'es',
                        'format' => 'dd/mm/yyyy',
                        'autoclose' => true,
                        'startDate' => ($controlValor->fecha),
                        'endDate' => ($controlValor->fecha),
                    ],
                    'htmlOptions' => ['readonly' => 'readonly']
                ],
                'wrapperHtmlOptions' => ['class' => 'col-sm-9 input-group-sm'],
                'prepend' => '<i class="fa fa-calendar"></i>'
            ]); ?>

            <?php echo $form->numberFieldGroup($controlValor,'valor',array('class'=>'col-sm-5',)); ?>
<!--            --><?php //echo $form->textFieldGroup($controlValor,'control_id',array('class'=>'col-sm-5')); ?>
<!--            --><?php //echo $form->textFieldGroup($controlValor,'creaUserStamp',array('class'=>'col-sm-5','maxlength'=>50)); ?>
<!--            --><?php //echo $form->textFieldGroup($controlValor,'creaTimeStamp',array('class'=>'col-sm-5')); ?>
<!--            --><?php //echo $form->textFieldGroup($controlValor,'modUserStamp',array('class'=>'col-sm-5','maxlength'=>50)); ?>
<!--            --><?php //echo $form->textFieldGroup($controlValor,'modTimeStamp',array('class'=>'col-sm-5')); ?>
    
<!--    <div class="box-footer">-->
<!--        --><?php //$this->widget('booster.widgets.TbButton', array(
//			'buttonType'=>'submit',
//			'context'=>'primary',
//			'label'=>$controlValor->isNewRecord ? 'Crear' : 'Guardar',
//			'size'=>'small'
//		)); ?>
<!---->
<!--        --><?php //$this->widget('bootstrap.widgets.TbButton', array(
//			//'buttonType'=>'submit',
//			'label'=> 'Cancelar',
//			'size' => 'small',
//			'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
//		)); ?>
<!--    </div>-->
    <?php $this->endWidget(); ?>

</div>