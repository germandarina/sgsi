<script>
    function obtenerOrden() {
        var id = $("#Menu_padreId").val()
        if (id == "") {
            id = 0;
        }
        $.ajax({
            type: 'GET',
            url: "<?php echo CController::createUrl('menu/getOrden') ?>",
            data: {'padreId': id},
            dataType: 'Text',
            success: function (data) {
                $("#Menu_orden").val(data);
            }
        });

    }
</script>

<div class="box-body">
    <?php
    /** @var TbActiveForm $form */
    $form = $this->beginWidget(
        'booster.widgets.TbActiveForm',
        array(
            'id' => 'verticalForm',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'type' => 'horizontal',
            // 'htmlOptions' => array('class' => 'well'), // for inset effect
        )
    );

    echo $form->errorSummary($model);

    echo $form->textFieldGroup($model, 'label', array(
        'wrapperHtmlOptions' => array(
            'class' => 'col-sm-4 input-group-sm',
        ),
    ));

    echo $form->select2Group(
        $model,
        'padreId',
        array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-4 input-group-sm',
                'onchange' => '{ obtenerOrden();}',

            ),
            'widgetOptions' => array(
                'asDropDownList' => true,
                'data' => CHtml::listData(Menu::model()->findPadre(), 'id', 'label'),
                'htmlOptions' => array('prompt' => '--Seleccione--')
            ),
        )
    );

    echo $form->textFieldGroup($model, 'titulo', array(
        'wrapperHtmlOptions' => array(
            'class' => 'col-sm-4 input-group-sm',
        ),
    ));

    echo $form->textFieldGroup($model, 'url', array(
        'wrapperHtmlOptions' => array(
            'class' => 'col-sm-4 input-group-sm',
        ),
    ));

    echo $form->textFieldGroup($model, 'orden', array(
        'wrapperHtmlOptions' => array(
            'class' => 'col-sm-4 input-group-sm',
        ),
    ));

    echo $form->textFieldGroup($model, 'icono', array(
        'wrapperHtmlOptions' => array(
            'class' => 'col-sm-4 input-group-sm',
        ),
    ));

    echo $form->checkboxGroup($model, 'visible');

    echo $form->select2Group(
        $model,
        'perfiles',
        array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-4 input-group-sm',
            ),
            'widgetOptions' => array(
                'asDropDownList' => true,
                'data' => $perfiles,
                'htmlOptions' => [
                    'multiple'=>'multiple'
                ],
                'options' => [
                    'minimumResultsForSearch' => 10,
                    'placeholder' => '--Seleccione--',
                ],
            ),
        )
    );

    $this->widget(
        'booster.widgets.TbButton',
        array('buttonType' => 'submit', 'label' => $model->isNewRecord ? 'Crear' : 'Actualizar', 'context' => 'primary', 'size' => 'small')
    );

    $this->endWidget();
    unset($form);
    ?>
</div>
