<div class="card">
    <div class="card-body card-padding">
        <?php    
            /** @var TbActiveForm $form */
            $form = $this->beginWidget(
                'mdWidgets.MdActiveForm',
                array(
                    'id' => 'verticalForm',
                    'type' => 'horizontal',
                    // 'htmlOptions' => array('class' => 'well'), // for inset effect
                )
            );
            
            echo $form->errorSummary($model); ?>

	<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

	<p class="note"><span class="required">	Recuerde que para que los cambios tengan efecto deben reiniciar sesion TODOS los usuarios</span></p>

	<?php echo $form->errorSummary($model); 

	echo $form->textFieldGroup($model, 'nombre', array(
        				'wrapperHtmlOptions' => array(
        					'class' => 'col-sm-4 input-group-sm',
        				),
        	)); 

    echo $form->textFieldGroup($model, 'direccion', array(
        				'wrapperHtmlOptions' => array(
        					'class' => 'col-sm-4 input-group-sm',
        				),
        	)); 

  	echo $form->textFieldGroup($model, 'email', array(
        				'wrapperHtmlOptions' => array(
        					'class' => 'col-sm-4 input-group-sm',
        				),
        	)); 

 	echo $form->textFieldGroup($model, 'comisionGeneral', array(
        				'wrapperHtmlOptions' => array(
        					'class' => 'col-sm-4 input-group-sm',
        				),
        	)); 

 	echo $form->textFieldGroup($model, 'tasaDescuentoGeneral', array(
        				'wrapperHtmlOptions' => array(
        					'class' => 'col-sm-4 input-group-sm',
        				),
        	)); 


 	echo $form->textFieldGroup($model, 'tasaInversores', array(
        				'wrapperHtmlOptions' => array(
        					'class' => 'col-sm-4 input-group-sm',
        				),
        	)); 

 	echo $form->textFieldGroup($model, 'tasaPesificacion', array(
        				'wrapperHtmlOptions' => array(
        					'class' => 'col-sm-4 input-group-sm',
        				),
        	)); 

   echo $form->textFieldGroup($model, 'tasaPesificacionCorriente', array(
        				'wrapperHtmlOptions' => array(
        					'class' => 'col-sm-4 input-group-sm',
        				),
        	)); 

   echo $form->textFieldGroup($model, 'tasaPromedioPesificacion', array(
        				'wrapperHtmlOptions' => array(
        					'class' => 'col-sm-4 input-group-sm',
        				),
        	)); 

    echo $form->textFieldGroup($model, 'tasaPromedioColocacion', array(
        				'wrapperHtmlOptions' => array(
        					'class' => 'col-sm-4 input-group-sm',
        				),
        	)); ?>

    <!--
    <div class="row">
		<?php //echo $form->labelEx($model,'operadorEmpresaId'); ?>
		<?php //echo $form->dropDownList($model,'operadorEmpresaId', CHtml::listData(Operadores::model()->findAll(), 'id', 'apynom')); ?>
		<?php //echo $form->error($model,'operadorEmpresaId'); ?>
	</div>
	-->	

	<?php
	 echo $form->textFieldGroup($model, 'diasChequeCorrientePasado', array(
        				'wrapperHtmlOptions' => array(
        					'class' => 'col-sm-4 input-group-sm',
        				),
        	));

	  echo $form->textFieldGroup($model, 'diasChequeCorrienteFuturo', array(
        				'wrapperHtmlOptions' => array(
        					'class' => 'col-sm-4 input-group-sm',
        				),
        	));

	  echo $form->textFieldGroup($model, 'empresaContrato', array(
        				'wrapperHtmlOptions' => array(
        					'class' => 'col-sm-4 input-group-sm',
        				),
        	));
 echo $form->textFieldGroup($model, 'personaContrato', array(
        				'wrapperHtmlOptions' => array(
        					'class' => 'col-sm-4 input-group-sm',
        				),
        	));

 echo $form->textFieldGroup($model, 'domicilioContrato', array(
        				'wrapperHtmlOptions' => array(
        					'class' => 'col-sm-4 input-group-sm',
        				),
        	));

 echo $form->textFieldGroup($model, 'dniContrato', array(
        				'wrapperHtmlOptions' => array(
        					'class' => 'col-sm-4 input-group-sm',
        				),
        	));

echo $form->checkboxGroup($model, 'cierreDiarioSinColocaciones');

$this->widget(
             'booster.widgets.TbButton',
              array('buttonType' => 'submit', 'label' => $model->isNewRecord ? 'Crear' : 'Actualizar', 'context' => 'primary', 'size' => 'small')
            );
$this->endWidget();
unset($form);
?>
</div>
</div>