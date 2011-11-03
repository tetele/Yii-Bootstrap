<?php

class BTabs extends CWidget {
	public $items = array();
	
	public $type = 'tabs';
	
	public $htmlOptions = array();
	public $navOptions = array();
	
	public function init() {
		if(!isset($this->htmlOptions['id']))
			$this->htmlOptions['id'] = $this->id;
		if($this->type != 'pills')
			$this->type = 'tabs';
		
		$this->navOptions['class'] = (isset($this->navOptions['class']) ? $this->navOptions['class'] : '') . ' '.$this->type;
		$this->navOptions['data-'.$this->type] = $this->type;
	}
	
	public function addTab($title, $content, $id = false) {
		$item = array(
			'title'=>$title,
			'content'=>$content,
		);
		if($id === false) {
			$id = preg_replace('/\W+/','-',strtolower($title));
		}
			$this->items[$id] = $item;
	}
	
	public function run() {
		$nav = $content = '';
		$first = true;
		$type = rtrim($this->type, 's');
		
		foreach($this->items as $id => $item) {
			$id = "{$this->id}-{$id}";

			$opts = $first ? array('class'=>'active') : array();
			$nav .= CHtml::tag('li', $opts, CHtml::link($item['title'], "#{$id}"));
			
			$opts['id'] = $id;
			$content .= CHtml::tag('div', $opts, $item['content']);
			
			$first = false;
		}
		echo CHtml::tag('div', $this->htmlOptions,
			CHtml::tag('ul', $this->navOptions,$nav)
			.CHtml::tag('div', array('class'=>'tab-content'), $content)
		);
		
		$cs = Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/bootstrap-tabs.js', CClientScript::POS_END);
	}
}