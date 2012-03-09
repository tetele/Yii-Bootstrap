<?php

Yii::import('zii.widgets.CBreadcrumbs');

class BBreadcrumbs extends CBreadcrumbs {
	public function run()
	{
		if(empty($this->links))
			return;
		
		if(isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] .= ' breadcrumb';
		else
			$this->htmlOptions['class'] = 'breadcrumb';

		echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
		$links=array();
		if($this->homeLink===null)
			$links[]=CHtml::link(Yii::t('zii','Home'),Yii::app()->homeUrl);
		else if($this->homeLink!==false)
			$links[]=$this->homeLink;
		foreach($this->links as $label=>$url)
		{
			if(is_string($label) || is_array($url))
				$links[]=CHtml::link($this->encodeLabel ? CHtml::encode($label) : $label, $url);
			else
				$links[]='<span>'.($this->encodeLabel ? CHtml::encode($url) : $url).'</span>';
		}
		$separator = CHtml::tag('span',array('class'=>'divider'),$this->separator) . CHtml::closeTag('li').' '.CHtml::openTag('li');
		echo CHtml::openTag('li').implode($separator,$links).CHtml::closeTag('li');
		echo CHtml::closeTag($this->tagName);
	}
}