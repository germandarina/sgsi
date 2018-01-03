<style>
	.login-page, .register-page {
		background-image: url(<?= Yii::app()->baseUrl.'/images/fondo2.jpg' ?>) !important;
	}
</style>
|
<div class="login-box">
	<div class="login-logo">

	</div><!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">
			<img src="<?= Yii::app()->baseUrl.'/images/logo-dime.png' ?>"
				 class="img-responsive" >
<!--			--><?php //echo CHtml::image(Yii::app()->baseUrl.'/images/logo-dime.png', 'DIME-SGSI',array(
//				'style' => 'width:200px;')); ?>
		</p>
		<?php
		$form = $this->beginWidget(
			'booster.widgets.TbActiveForm',
			array(
				'id' => 'form',
				//'htmlOptions' => array('style' => 'margin-top: 200px'), // for inset effect
			)
		);
		?>
		<?php $errors = $model->getErrors() ?>
			<div class="form-group has-feedback <?php if($errors) echo 'has-error' ?>">
				<?php if($errors && isset($errors['password'])) { ?>
					<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i><?= current($errors['password']) ?></label>
				<?php } ?>
				<input type="text" class="form-control" name="LoginForm[username]"  placeholder="Usuario"/>
				<span class="glyphicon glyphicon-user form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback <?php if($errors) echo 'has-error' ?>">
				<input type="password" class="form-control" name="LoginForm[password]" placeholder="Password"/>
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="row">
				<div class="col-xs-8">
					<div class="checkbox icheck">
						<label>
							<input type="checkbox"> Recordarme
						</label>
					</div>
				</div><!-- /.col -->
				<div class="col-xs-4">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
				</div><!-- /.col -->
			</div>
		<?php
		$this->endWidget();
		unset($form);
		?>

		<a href="#">Olvidé mi contraseña</a><br>

	</div><!-- /.login-box-body -->
</div><!-- /.login-box -->