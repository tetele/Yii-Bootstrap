<?php
$this->pageCaption='Contact Us';
$this->pageTitle=Yii::app()->name . ' - ' . $this->pageCaption;
$this->pageDescription='Send us feedback';
$this->breadcrumbs=array(
	'Contact',
);
?>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

<?php $this->beginWidget('BAlert',array('type'=>'success')); ?>
<?php echo Yii::app()->user->getFlash('contact'); ?>
<?php $this->endWidget(); ?>

<?php else: ?>

<p>
If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
</p>

<div class="form">

<?php $form=$this->beginWidget('BActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
//	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
	<?php $this->beginWidget('BAlert',array()); ?>
	<p>Fields with <span class="required">*</span> are required.</p>
	<?php $this->endWidget(); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="<?php echo $form->fieldClass($model, 'name'); ?>">
		<?php echo $form->labelEx($model,'name'); ?>
		<div class="controls">
			<?php echo $form->textField($model,'name'); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	</div>

	<div class="<?php echo $form->fieldClass($model, 'email'); ?>">
		<?php echo $form->labelEx($model,'email'); ?>
		<div class="controls">
			<?php echo $form->textField($model,'email'); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>
	</div>

	<div class="<?php echo $form->fieldClass($model, 'subject'); ?>">
		<?php echo $form->labelEx($model,'subject'); ?>
		<div class="controls">
			<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128)); ?>
			<?php echo $form->error($model,'subject'); ?>
		</div>
	</div>

	<div class="<?php echo $form->fieldClass($model, 'body'); ?>">
		<?php echo $form->labelEx($model,'body'); ?>
		<div class="controls">
			<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'body'); ?>
		</div>
	</div>

	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="<?php echo $form->fieldClass($model, 'verifyCode'); ?>">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<div class="controls">
			<?php $this->widget('CCaptcha'); ?><br/>
			<?php echo $form->textField($model,'verifyCode'); ?>
			<?php echo $form->error($model,'verifyCode'); ?>
			<p class="help-block">
				Please enter the letters as they are shown in the image above.
				<br/>Letters are not case-sensitive.
			</p>
		</div>
	</div>
	<?php endif; ?>

	<div class="form-actions">
		<?php echo BHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>