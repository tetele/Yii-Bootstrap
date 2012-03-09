<?php 
/**
 * BAlert class file
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
 * BAlert is a widget which displays Bootstrap-styled messages to the user.
 *
 * @author Tudor Sandu <tm.sandu@gmail.com>
 * @version 0.1
 * @package bootstrap
 * @since 0.1
 */
class BAlert extends CWidget {
	/**
	 * @var string content to be appended at the end
	 */
	public $content = ''; 
	
	/**
	 * @var string the alert type. Can be any of (info|warning|error|success)
	 */
	public $type = 'info';
	
	/**
	 * @var boolean if the alert message has a close button
	 */
	public $canClose = true;
	
	/**
	 * @var boolean if the alert is a block message instead of a single line
	 */
	public $isBlock = false;
	
	/**
	 * @var boolean if closing should be accompanied by a fading effect
	 */
	public $fadeWhenClose = true;
	
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
	public $actions = array();
	
	/**
	 * @var array additional HTML attributes that should be rendered for the container div tag.
	 */
	public $htmlOptions = array();
	
	public function init() {
		if($this->canClose) {
			BHtml::registerBootstrapJs();
		}
		$class = array();
		$class[] = 'alert';
		if($this->isBlock)
			$class[] = 'alert-block';
		if(in_array($this->type, array('warning', 'error', 'success', 'danger', 'info')))
			$class[] = 'alert-'.$this->type;
		else
			$class[] = 'info';
		if($this->canClose && $this->fadeWhenClose)
			$class[] = 'fade in';
		$htmlOptions = $this->htmlOptions;
		if(!isset($htmlOptions['class']))
			$htmlOptions['class']=implode(' ',$class);
		else
			$htmlOptions['class']=implode(' ',array_merge(explode(' ',$htmlOptions['class']),$class));
		$htmlOptions['data-alert'] = 'alert';
		
		$html = '';
		Yii::trace(CVarDumper::dumpAsString($this->canClose));
		if($this->canClose)
			$html .= CHtml::link('&times;','#',array('class'=>'close', 'data-dismiss'=>'alert'));
		
		echo CHtml::openTag(
			'div',
			$htmlOptions
		).$html;
	}
	
	public function run() {
		$html = $this->content;
		if(!empty($this->actions)) {
			$actions = array();
			foreach($this->actions as $action) {
				if(!is_array($action))
					$action = array('text'=>$action);
				if(!isset($action['text']))
					$action['text'] = 'Action';
				if(!isset($action['url']))
					$action['url'] = '#';
				if(!isset($action['htmlOptions']))
					$action['htmlOptions'] = array('class'=>'btn');
				else
					$action['htmlOptions']['class'] = isset($action['htmlOptions']['class']) ? $action['htmlOptions']['class'].' btn' : 'btn';
				$actions[] = CHtml::link($action['text'], $action['url'], $action['htmlOptions']);
			}
			$html .= CHtml::tag('p',array(),implode("\n",$actions));
		}
		
		echo $html . CHtml::closeTag('div');
	}
}