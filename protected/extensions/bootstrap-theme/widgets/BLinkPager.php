<?php 

class BLinkPager extends CLinkPager {
	const CSS_HIDDEN_PAGE='disabled';
	const CSS_SELECTED_PAGE='active';
	
	public function init() {
		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class']='';
		if(!isset($this->header))
			$this->header = '';
		parent::init();
		if($this->htmlOptions['class'] === '')
			unset($this->htmlOptions['class']);
	}
	
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
		return '<li class="'.$class.'">'.CHtml::link($label,$this->createPageUrl($page)).'</li>';
	}
	
	public function run() {
		echo CHtml::openTag('div',array('class'=>'pagination'));
		parent::run();
		echo CHtml::closeTag('div');
	}
}