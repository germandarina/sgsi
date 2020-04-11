<script>
    function verificarPerfil() {
        var esAdministrador = false;

        if($('#perfiles').val() != null) {
            $.each($('#perfiles').val(), function (i, perfil) {
                if(perfil == 'Administrador') {
                    esAdministrador = true;
                }
            });
        }

        if(esAdministrador) {
            $('#containerJornada').hide();
        } else {
            $('#containerJornada').show();
        }
    }
</script>

<div class="box-body">
    <?php $form = $this->beginWidget('customYiiBooster.widgets.CustomTbActiveForm', array(
        'id' => 'user-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'type' => 'horizontal'
    )); ?>

    <p class="help-block">Campos con <span class="required">*</span> son requeridos.</p>

    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->emailFieldGroup($model, 'username', array('class' => 'col-sm-6', 'maxlength' => 50)); ?>
        </div>
        <?php if($model->isNewRecord){ ?>
            <div class="col-sm-6">
                <?php echo $form->passwordFieldGroup($model, 'password', array('class' => 'col-sm-6', 'maxlength' => 255)); ?>
            </div>
        <?php }?>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php
            if(!Yii::app()->user->model->isGerencial()){
                if (!$model->isNewRecord)
                    $value = array_keys(Yii::app()->authManager->getAuthAssignments($model->id));
                else
                    $value = array();

                $model->perfil = $value;
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
                                'multiple' => 'multiple',
                                'onchange' => 'verificarPerfil()',
                                'id' => 'perfiles',
                                'value' => 'Administrador'
                            ],
                            'options' => [
                                'minimumResultsForSearch' => 10,
                                'placeholder' => '--Seleccione--',
                            ],
                        ),
                    )
                );

            }else{
              echo  '<input type="hidden" name="User[perfil][]" id="User_perfil" value="'.$perfilAuditor.'">';
            }
            ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->select2Group(
                $model, 'estado',
                [
                    'wrapperHtmlOptions' => ['class' => 'col-sm-12 input-group-sm',],
                    'widgetOptions' => [
                        'asDropDownList' => true,
                        'data' => $model->getTypeOptionsHabilitar(),
                        'options' => [
                            'minimumResultsForSearch' => 10,
                            'placeholder' => '--Seleccione--'
                        ],
//                        'htmlOptions' => ['onChange'=>'getProcesos()'],
                    ],
                ]
            );
            ?>
        </div>
    </div>
    <br>
    <fieldset id="containerJornada" style="display: none">
        <legend>Jornada Laboral</legend>
        <div class="row">
            <div class="col-sm-6">
                <?php
                echo $form->labelEx($model, 'diaDesde', array('class' => 'col-sm-3'));
                echo $form->dropDownList($model,
                    'diaDesde',
                    $model->getTypeOptions(),
                    array('empty' => 'Seleccionar..', 'class' => 'col-sm-9',
                        'style' => 'height:35px')
                ); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->labelEx($model, 'diaHasta', array('class' => 'col-sm-3'));
                echo $form->dropDownList($model,
                    'diaHasta',
                    $model->getTypeOptions(),
                    array('empty' => 'Seleccionar..', 'class' => 'col-sm-9',
                        'style' => 'height:35px')
                ); ?>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-6">
                <?php echo $form->labelEx($model, 'horaDesde', array('class' => 'col-sm-3')); ?>
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
                <?php echo $form->labelEx($model, 'horaHasta', array('class' => 'col-sm-3')); ?>
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
        </div>
        <br>

    </fieldset>

    <div class="box-footer">
        <br>
        <?php $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context' => 'primary',
            'label' => $model->isNewRecord ? 'Crear' : 'Guardar',
            'size' => 'small'
        )); ?>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            //'buttonType'=>'submit',
            'label' => 'Cancelar',
            'size' => 'small',
            'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
        )); ?>
    </div>
    <?php $this->endWidget(); ?>

</div>