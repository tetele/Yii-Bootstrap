<?php
$this->pageTitle=Yii::app()->name . ' - Error';
$this->pageCaption = 'Error';
$this->pageDescription = $code;
$this->breadcrumbs=array(
	'Error',
);
?>

<?php $this->widget('BAlert',array(
	'content'=>CHtml::encode($message),
	'type'=>'error',
	'isBlock'=>true,
	'canClose'=>false,
)); ?>