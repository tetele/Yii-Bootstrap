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
class BPopover extends CWidget {
	public $selector = '[rel=\\"popover\\"]';
	
	public $animate = true;
	
	public $delayIn = 0;
	
	public $delayOut = 0;
	
	public $fallback = '';
	
	public $placement = 'right';
	
	public $html = true;
	
	public $live = false;
	
	public $offset = 0;
	
	public $title = 'title';
	
	public $content = 'data-content';
	
	public $trigger = 'hover';
	
	public function run() {
		$options = array();
		$optionNames = array(
			'animate',
			'delayIn',
			'delayOut',
			'fallback',
			'placement',
			'html',
			'live',
			'offset',
			'title',
			'title',
			'content',
			'trigger',
		);
		
		foreach($optionNames as $name)
			$options[$name] = $this->$name;
		
		$cs = Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/bootstrap-twipsy.js');
		$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/bootstrap-popover.js');
		$cs->registerScript('BPopover#'.$this->id,'$("'.$this->selector.'").popover('.CJSON::encode($options).');');
	}
}