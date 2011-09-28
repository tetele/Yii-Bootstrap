<?php
/**
 * This is the template for generating an action view file.
 * The following variables are available in this template:
 * - $this: the ControllerCode object
 * - $action: the action ID
 */
?>
<?php
$label=ucwords(trim(strtolower(str_replace(array('-','_','.'),' ',preg_replace('/(?<![A-Z])[A-Z]/', ' \0', basename($this->getControllerID()))))));
echo "<?php
\$this->pageCaption=\$this->id . '/' . \$this->action->id;
\$this->pageTitle=Yii::app()->name . ' - ' . \$this->pageCaption;\n";
if($action==='index')
{
	echo "\$this->pageDescription=Yii::app()->name . ' $label page';\n";
	echo "\$this->breadcrumbs=array(
	'$label',
);";
}
else
{
	$action=ucfirst($action);
	echo "\$this->pageDescription=Yii::app()->name . ' $label $action page';\n";
	echo "\$this->breadcrumbs=array(
	'$label'=>array('/{$this->uniqueControllerID}'),
	'$action',
);";
}
?>
?>
<p>
	You may change the content of this page by modifying
	the file <tt><?php echo '<?php'; ?> echo __FILE__; ?></tt>.
</p>
