<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<div class="wide form">

<?php echo "<?php \$form=\$this->beginWidget('BActiveForm', array(
	'action'=>Yii::app()->createUrl(\$this->route),
	'method'=>'get',
)); ?>\n"; ?>

<?php foreach($this->tableSchema->columns as $column): ?>
<?php
	$field=$this->generateInputField($this->modelClass,$column);
	if(strpos($field,'password')!==false)
		continue;
?>
	<div class="clearfix">
		<?php echo "<?php echo \$form->label(\$model,'{$column->name}'); ?>\n"; ?>
		<div class="input">
			<?php echo "<?php echo ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; ?>
		</div>
	</div>

<?php endforeach; ?>
	<div class="actions">
		<?php echo "<?php echo BHtml::submitButton('Search'); ?>\n"; ?>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- search-form -->