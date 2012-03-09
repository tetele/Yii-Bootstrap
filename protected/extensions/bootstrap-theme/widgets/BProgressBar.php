<?php 

class BProgressBar extends CWidget {
	public $progress = 0;
	public $type = false;
	public $striped = true;
	public $animated = true;
	public $htmlOptions = array();
	
	public function run() {
		$progress = min(100,max(0,intval($this->progress)));
		$class = 'progress ';
		if($this->striped)
			$class .= 'progress-striped ';
		if($this->animated)
			$class .= 'active ';
		if(in_array($this->type,array('info','warning','success','danger')))
			$class .= 'progress-'.$this->type.' ';
		if(isset($this->htmlOptions['class']))
			$class .= $this->htmlOptions['class'];
		$this->htmlOptions['class'] = $class;
		
		echo CHtml::tag('div',$this->htmlOptions,CHtml::tag('div',array(
			'class'=>'bar',
			'style'=>"width: $progress%;"
		),''));
	}
}