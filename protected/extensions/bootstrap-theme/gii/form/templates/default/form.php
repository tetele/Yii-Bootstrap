<?php
/**
 * This is the template for generating a form script file.
 * The following variables are available in this template:
 * - $this: the FormCode object
 */
?>
<?php echo "<?php
\$this->pageCaption='".$this->modelClass.' '.$this->viewName." form';
\$this->pageTitle=Yii::app()->name . ' - ' . \$this->pageCaption;
\$this->pageDescription=Yii::app()->name . ' ' . \$this->pageCaption . ' page';
\$this->breadcrumbs=array(
	'{$this->viewName}',
);
?>"; ?>
<div class="form">

<?php echo "<?php \$form=\$this->beginWidget('BActiveForm', array(
	'id'=>'".$this->class2id($this->modelClass).'-'.basename($this->viewName)."-form',
	'enableAjaxValidation'=>false,
)); ?>\n"; ?>

	<?php echo "<?php \$this->widget('BAlert',array(\n
		'content'=>'<p>Fields with <span class=\"required\">*</span> are required.</p>'
	)); ?>\n"; ?>

	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php foreach($this->getModelAttributes() as $attribute): ?>
	<div class="<?php echo "<?php echo \$form->fieldClass(\$model, '$attribute'); ?>"; ?>">
		<?php echo "<?php echo \$form->labelEx(\$model,'$attribute'); ?>\n"; ?>
		<div class="controls">
			<?php echo "<?php echo \$form->textField(\$model,'$attribute'); ?>\n"; ?>
			<?php echo "<?php echo \$form->error(\$model,'$attribute'); ?>\n"; ?>
		</div>
	</div>

<?php endforeach; ?>

	<div class="form-actions">
		<?php echo "<?php echo BHtml::submitButton('Submit'); ?>\n"; ?>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- form -->