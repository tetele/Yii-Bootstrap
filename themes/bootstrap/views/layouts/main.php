<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Le styles -->
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/application.min.css" rel="stylesheet">

	<!-- Le fav and touch icons -->
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico">
	<link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo Yii::app()->request->baseUrl; ?>/images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo Yii::app()->request->baseUrl; ?>/images/apple-touch-icon-114x114.png">
</head>

<body>
	<div class="topbar">
		<div class="fill">
			<div class="container">
				<a class="brand" href="<?php echo $this->createAbsoluteUrl('//'); ?>"><?php echo CHtml::encode(Yii::app()->name); ?></a>
				<?php $this->widget('zii.widgets.CMenu',array(
					'items'=>array(
						array('label'=>'Home', 'url'=>array('/site/index')),
						array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
						array('label'=>'Contact', 'url'=>array('/site/contact')),
						array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
					),
					'htmlOptions'=>array(
						'class'=>'nav',
					),
				)); ?>
				<?php if(Yii::app()->user->isGuest) : ?>
				<?php 
				$login = new LoginForm;
				$form=$this->beginWidget('CActiveForm', array(
					'id'=>'login-form',
					'action'=>$this->createUrl('site/login'),
					'enableClientValidation'=>false,
					'htmlOptions'=>array(
						'class'=>'pull-right',
					),
				)); ?>
					<?php echo $form->textField($login,'username',array(
						'class'=>'input-small',
						'placeholder'=>$login->getAttributeLabel('username'),
					)); ?>
					<?php echo $form->passwordField($login,'password',array(
						'class'=>'input-small',
						'placeholder'=>$login->getAttributeLabel('password'),
					)); ?>
					<button class="btn" type="submit">Sign in</button>
				<?php $this->endWidget(); ?>
				<?php endif; ?>
				<?php $this->widget('zii.widgets.CMenu',array(
					'items'=>array(
						array('label'=>Yii::app()->user->name, 'url'=>array('site/profile'), 'visible'=>!Yii::app()->user->isGuest),
						array('label'=>'Logout', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest, 'htmlOptions'=>array('class'=>'btn'))
					),
					'htmlOptions'=>array(
						'class'=>'nav secondary-nav',
					),
				)); ?>
			</div>
		</div>
	</div>
	
	<div class="container">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
			'htmlOptions'=>array('class'=>'breadcrumb'),
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	</div>
	
	<?php echo $content; ?>
	
	<footer class="footer">
		<div class="container">
			<p>Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
			All Rights Reserved.<br/>
			<?php echo Yii::powered(); ?></p>
		</div>
	</footer>
	
</body>
</html>