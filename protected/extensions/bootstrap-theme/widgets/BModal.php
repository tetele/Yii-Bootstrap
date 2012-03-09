<?php 
/**
 * BModal class file
 * 
 * @author Tudor Sandu <tm.sandu@gmail.com>
 * @link https://github.com/tetele/Yii-Bootstrap
 * @copyright Copyright (c) 2011, Tudor Sandu. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD
 * 
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 * - Redistributions of source code must retain the above copyright notice, this list
 *   of conditions and the following disclaimer.
 * - Redistributions in binary form must reproduce the above copyright notice, this list
 *   of conditions and the following disclaimer in the documentation and/or other materials
 *   provided with the distribution.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS
 * OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
 * AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER
 * IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT
 * OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

/**
 * BModal alows easy creation of modal windows
 *
 * @author Tudor Sandu <tm.sandu@gmail.com>
 * @version 0.1
 * @package bootstrap
 * @since 0.1
 */
class BModal extends CWidget {
	/**
	 * @var boolean if the widget should be truly modal, with a dark background preventing the user
	 * from getting to the page below
	 * @link http://twitter.github.com/bootstrap/javascript.html#modal
	 */
	public $backdrop=false;
	
	/**
	 * @var boolean if pressing the escape key closes the modal
	 * @link http://twitter.github.com/bootstrap/javascript.html#modal
	 */
	public $keyboard=false;
	
	/**
	 * @var boolean whether to show the modal automatically when page loads
	 */
	public $show=false;
	
	/**
	 * @var boolean if the modal should have a nice fade/slide effect upon opening/closing
	 */
	public $fade=true;
	
	/**
	 * @var array additional HTML attributes that should be rendered for the container div tag.
	 */
	public $htmlOptions=array();
	
	/**
	 * @var string the window caption or heading
	 */
	public $heading='Modal window';
	
	/**
	 * @var array list of buttons to be present in a block alert footer. Each list item
	 * should can be either a label or an associative array with the following keys:
	 * <ul>
	 * <li>text</li>
	 * <li>url</li>
	 * <li>htmlOptions</li>
	 * </ul>
	 * These items will be used as building blocks for a call to {@link CHtml::link}
	 * @see CHtml::link
	 */
	public $actions=array();
	
	public function init() {
		if(!isset($this->htmlOptions['id']))
			$this->htmlOptions['id']=$this->id;
		$this->htmlOptions['class']='modal';
		if($this->fade)
			$this->htmlOptions['class'] .= ' fade';
		echo BHtml::openTag('div',$this->htmlOptions);
		$header = BHtml::link('&times;','#',array('class'=>'close','data-dismiss'=>'modal'));
		if($this->heading)
			$header .= BHtml::tag('h3',array(),$this->heading);
		echo BHtml::tag('div',array('class'=>'modal-header'),$header);
		echo BHtml::openTag('div',array('class'=>'modal-body','id'=>$this->id.'-body'));
	}
	
	public function run() {
		echo BHtml::closeTag('div'); // body
		if(!empty($this->actions)) {
			$actions = array();
			foreach($this->actions as $action) {
				$tagType = 'link';
				if(!is_array($action))
					$action = array('text'=>$action);
				if(!isset($action['text']))
					$action['text'] = 'Action';
				if(!isset($action['url']))
					$tagType = 'button';
				if(!isset($action['htmlOptions']))
					$action['htmlOptions'] = array('class'=>'btn small');
				else
					$action['htmlOptions']['class'] = (isset($action['htmlOptions']['class']) ? $action['htmlOptions']['class'].' ' : '') . 'btn small';
				if(isset($action['primary']) && $action['primary'])
					$action['htmlOptions']['class'] .= ' primary';
				if(isset($action['onclick']))
					$action['htmlOptions']['onclick'] = (isset($action['htmlOptions']['onclick']) ? $action['htmlOptions']['onclick'] : '').$action['onclick'];
				if(isset($action['close']) && $action['close'])
					$action['htmlOptions']['onclick'] = (isset($action['onclick']) ? $action['onclick'] : '').';$("#'.$this->id.'").modal("hide");';
				$actions[] = ($tagType == 'link')
					? CHtml::link($action['text'], $action['url'], $action['htmlOptions'])
					: BHtml::button($action['text'], $action['htmlOptions']);
			}
			echo BHtml::tag('div',array('class'=>'modal-footer'),implode("\n",$actions));
		}

		echo BHtml::closeTag('div'); // container
		
		BHtml::registerBootstrapJs();
	}
	
	/**
	 * Renders a button that makes the modal window appear. Great for those situations
	 * when {@link $show} is set to false
	 */
	public function toggleButton($text,$htmlOptions=array()) {
		$htmlOptions['data-backdrop']=$this->backdrop;
		$htmlOptions['data-keyboard']=(bool)$this->keyboard;
		$htmlOptions['data-show']=(bool)$this->show;
		echo BHtml::modalButton($text,$this->id,$htmlOptions);
	}
	
	/**
	 * Makes modal window show up via JavaScript, without any trigger component
	 */
	public function show($return=false) {
		$options = array(
			'backdrop'=>$this->backdrop,
			'keyboard'=>(bool)$this->keyboard,
			'show'=>true,
		);
		$script = '$("#'.$this->id.'").modal('.CJSON::encode($options).');';
		if($return)
			return $script;
		else
			Yii::app()->clientScript->registerScript('BModal#'.$this->id,$script,CClientScript::POS_READY);
	}
}