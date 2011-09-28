<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<div class="form">

<?php echo "<?php \$form=\$this->beginWidget('BActiveForm', array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'enableAjaxValidation'=>false,
)); ?>\n"; ?>

	<?php echo "<?php \$this->widget('BAlert',array(\n
		'content'=>'<p>Fields with <span class=\"required\">*</span> are required.</p>'
	)); ?>\n"; ?>

	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php
foreach($this->tableSchema->columns as $column)
{
	if($column->autoIncrement)
		continue;
?>
	<div class="<?php echo "<?php echo \$form->fieldClass(\$model, '$column->name'); ?>"; ?>">
		<?php echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$column)."; ?>\n"; ?>
		<div class="input">
			<?php echo "<?php echo ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; ?>
			<?php echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n"; ?>
		</div>
	</div>

<?php
}
?>
	<div class="actions">
		<?php echo "<?php echo BHtml::submitButton(\$model->isNewRecord ? 'Create' : 'Save'); ?>\n"; ?>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- form -->