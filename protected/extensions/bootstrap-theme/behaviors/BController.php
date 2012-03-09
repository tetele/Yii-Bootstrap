<?php 

class BController extends CBehavior{
	private $_controller = null;
	public function __construct($controller) {
		$this->_controller = $controller;
	}
	
	private $_pageCaption = null;
	private $_pageDescription = null;
	
	public $sidebarCaption = 'Menu';
	
	/**
	 * @return string the page heading (or caption). Defaults to the controller name and the action name,
	 * without the application name.
	 */
	public function getPageCaption() {
		if($this->_pageCaption!==null)
			return $this->_pageCaption;
		else
		{
			$name=ucfirst(basename($this->_controller->getId()));
			if($this->_controller->getAction()!==null && strcasecmp($this->_controller->getAction()->getId(),$this->_controller->defaultAction))
				return $this->_pageCaption=$name.' '.ucfirst($this->_controller->getAction()->getId());
			else
				return $this->_pageCaption=$name;
		}
	}
	
	/**
	 * @param string $value the page heading (or caption)
	 */
	public function setPageCaption($value) {
		$this->_pageCaption = $value;
	}
	
	/**
	 * @return string the page description (or subtitle). Defaults to the page title + 'page' suffix.
	 */
	public function getPageDescription() {
		if($this->_pageDescription!==null)
			return $this->_pageDescription;
		else
		{
			return Yii::app()->name . ' ' . $this->getPageCaption() . ' page';
		}
	}
	
	/**
	 * @param string $value the page description (or subtitle)
	 */
	public function setPageDescription($value) {
		$this->_pageDescription = $value;
	}
}