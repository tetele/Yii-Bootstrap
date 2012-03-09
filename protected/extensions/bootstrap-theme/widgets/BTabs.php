<?php

class BTabs extends CWidget {
	public $items = array();
	
	public $type = 'tabs';
	public $stacked = false;
	public $position = false;
	
	public $htmlOptions = array();
	public $navOptions = array();
	
	public function init() {
		if(!isset($this->htmlOptions['id']))
			$this->htmlOptions['id'] = $this->id;
		if($this->type != 'pills')
			$this->type = 'tabs';
		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] = 'tabbable';
		else
			$this->htmlOptions['class'] .= ' tabbable';
		if(in_array($this->position,array('left','right','below')))
			$this->htmlOptions['class'] .= ' tabs-'.$this->position;
		
		$class = 'nav nav-'.$this->type;
		if($this->stacked)
			$class .= ' nav-stacked';
		$this->navOptions['class'] = (isset($this->navOptions['class']) ? $class.' '.$this->navOptions['class'] : $class);
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
	
	public function addTabDropdown($title, $tabs, $groupId = false) {
		
		$group = array();
		foreach($tabs as $id => $item) {
			$title = isset($item['title']) ? $item['title'] : $item[0];
			$content = isset($item['content']) ? $item['content'] : $item[1];
			
			if(is_numeric($id)) {
				$id = preg_replace('/\W+/','-',strtolower($title));
			}
			
			$group[$id] = $item;
		}
		$group = array(
			'title'=>$title,
			'content'=>$group,
		);
		
		if($groupId === false)
			$this->items[] = $group;
		else
			$this->items[$groupId] = $group;
	}
	
	public function run() {
		$nav = $content = '';
		$first = true;
		$type = rtrim($this->type,'s');
		
		foreach($this->items as $id => $item) {
			if(is_array($item['content'])) {
				$id = "{$this->id}-{$id}";

				$opts = $first ? array('class'=>'active') : array();
				$opts['class'] = isset($opts['class']) ? $opts['class'].' dropdown' : 'dropdown';
				$dropdown = array();
				
				foreach($item['content'] as $subId => $subTab) {
					Yii::trace(CVarDumper::dumpAsString($subTab));
					$subOpts = array();
					$subOpts['id'] = "{$id}-{$subId}";
					$subOpts['class'] = 'tab-pane';
					$content .= CHtml::tag('div', $subOpts, $subTab['content']);
					$dropdown[$subTab['title']] = '#'.$subOpts['id'];
				}
				
				Yii::trace(CVarDumper::dumpAsString($dropdown));
				
				$nav .= CHtml::tag('li', $opts, BHtml::dropdownToggle($item['title']).BHtml::dropdownMenu($dropdown,array('linkOptions'=>array('data-toggle'=>'tab'))));
			} else {
				$id = "{$this->id}-{$id}";

				$opts = $first ? array('class'=>'active') : array();
				$nav .= CHtml::tag('li', $opts, CHtml::link($item['title'], "#{$id}", array('data-toggle'=>$type)));
				
				$opts['id'] = $id;
				$opts['class'] = isset($opts['class']) ? $opts['class'].' tab-pane' : 'tab-pane';
				$content .= CHtml::tag('div', $opts, $item['content']);
			}
			
			$first = false;
		}
		echo CHtml::tag('div', $this->htmlOptions,
			CHtml::tag('ul', $this->navOptions,$nav)
			.CHtml::tag('div', array('class'=>'tab-content'), $content)
		);
		
		BHtml::registerBootstrapJs();
	}
}