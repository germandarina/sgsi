<style>
	.login-page, .register-page {
		background-image: url(<?= Yii::app()->baseUrl.'/images/fondo.jpg' ?>) !important;
		background-repeat: round;}
</style>
<script>

    function validarEmail() {
        var email = $("#LoginForm_email").val();
        if(email === ""){
            $("#divEmail").removeClass('has-feedback').addClass('has-error');
            $("#labelEmail").empty().html("Ingrese un correo electrónico").show();
            return;
        }
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if(!re.test(String(email).toLowerCase())){
            $("#divEmail").removeClass('has-feedback').addClass('has-error');
            $("#labelEmail").empty().html("Ingrese un correo electrónico válido").show();
            return;
        }
        $("#divEmail").removeClass('has-error').addClass('has-success');
        $("#labelEmail").empty().hide();
    }
</script>
	  	<div class="login-box">
		<div class="login-logo">

		</div><!-- /.login-logo -->
		<div class="login-box-body">
			<p class="login-box-msg">
				<img src="<?= /*Yii::app()->baseUrl.'/images/logo-dime.png'*/ '' ?>"
					 class="img-responsive" >
	<!--			--><?php //echo CHtml::image(Yii::app()->baseUrl.'/images/logo-dime.png', 'DIME-SGSI',array(
	//				'style' => 'width:200px;')); ?>
			</p>
			<?php
			$form = $this->beginWidget(
				'customYiiBooster.widgets.CustomTbActiveForm',
				array(
					'id' => 'form',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                    ),
					//'htmlOptions' => array('style' => 'margin-top: 200px'), // for inset effect
				)
			);
			?>
			<?php $errors = $model->getErrors() ?>
				<div class="row">
					<div class="col-xs-12">
						<img class="logo img-responsive" src="<?= Yii::app()->baseUrl.'/images/escudoWeb4.png'?>" alt="Force SGSI">
					</div>			

					<!--
					.logo {
	 					   max-width: 256px;
	    					height: 24px;
						  }
					-->
				</div>
				<div>
				<!--	<blockquote class="blockquote text-center">
						<span><h3>Login</h3></span>
						<h5>Por favor logueate para continuar</h5>	
					</blockquote>-->
					<span class="text-center"><h3>Login</h3></span>
					<h5 class="text-center">Por favor completa tus datos para continuar</h5>
				</div>
				<div id="divEmail" class="form-group has-feedback <?php if($errors) echo 'has-error' ?>">
					<?php if($errors && isset($errors['password'])) { ?>
						<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i><?= current($errors['password']) ?></label>
					<?php } ?>
                    <label id="labelEmail" style="display: none;" class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i></label>
					<input type="email" class="form-control" name="LoginForm[username]"  placeholder="Correo electrónico" id="LoginForm_email" onblur="validarEmail()" />
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback <?php if($errors) echo 'has-error' ?>">
					<input type="password" class="form-control" name="LoginForm[password]" placeholder="Contraseña"/>
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="checkbox icheck">
							<p>¿No tiene una cuenta? | <a href="#">Solicitar una cuenta</a></p> 
							<!--<label>
								<input type="checkbox"> Recordarme
							</label>-->
						</div>
					</div>
					<div class="col-xs-12">
						<button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
					</div><!-- /.col -->
				</div>
			<?php
			$this->endWidget();
			unset($form);
			?>

	<!--		<a href="#">Olvidé mi contraseña</a><br>-->

		</div><!-- /.login-box-body -->
		</div><!-- /.login-box -->