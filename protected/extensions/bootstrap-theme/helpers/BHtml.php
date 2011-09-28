<?php 
/**
 * BHtml class file
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
 * BHtml is a small wrapper on top of Yii's own CHtml helper. It allows easy integration of
 * Bootstrap-specific widgets
 *
 * @author Tudor Sandu <tm.sandu@gmail.com>
 * @version 0.1
 * @package bootstrap
 * @since 0.1
 */
class BHtml extends CHtml {
	const ID_PREFIX='ytb';
	
	/**
	 * Generates a Bootstrap-styled button.
	 * @param string $label the button label
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated button tag
	 * @see CHtml::clientChange
	 */
	public static function button($label='button',$htmlOptions=array())
	{
		if(!isset($htmlOptions['name']))
		{
			if(!array_key_exists('name',$htmlOptions))
				$htmlOptions['name']=self::ID_PREFIX.self::$count++;
		}
		if(!isset($htmlOptions['type']))
			$htmlOptions['type']='button';
		if(!isset($htmlOptions['value']))
			$htmlOptions['value']=$label;
		if(!isset($htmlOptions['class']))
			$htmlOptions['class']='btn';
		else 
			$htmlOptions['class'].=' btn';
		self::clientChange('click',$htmlOptions);
		return self::tag('input',$htmlOptions);
	}
	
	/**
	 * Generates a Bootstrap-styled submit button.
	 * @param string $label the button label
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated button tag
	 * @see CHtml::clientChange
	 */
	public static function submitButton($label='submit',$htmlOptions=array())
	{
		$htmlOptions['type']='submit';
		if(!isset($htmlOptions['class']))
			$htmlOptions['class'] = 'primary';
		return self::button($label,$htmlOptions);
	}
	
	/**
	 * Generates a link trigger for a modal widget
	 * @param string $text the link text
	 * @param string $target the modal widget ID
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated link tag
	 * @see CHtml::clientChange
	 */
	public function modalLink($text,$target,$htmlOptions=array()) {
		if(!isset($htmlOptions['href']))
			$htmlOptions['href']='#';
		$htmlOptions['data-controls-modal']=$target;
		return self::tag('a',$htmlOptions,$text);
	}
	
	/**
	 * Generates a button trigger for a modal widget
	 * @param string $text the link text
	 * @param string $target the modal widget ID
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated button tag
	 * @see CHtml::clientChange
	 */
	public function modalButton($text,$target,$htmlOptions=array()) {
		if(!isset($htmlOptions['href']))
			$htmlOptions['href']='#';
		$htmlOptions['data-controls-modal']=$target;
		return self::button($text,$htmlOptions);
	}
	
	public static $errorSummaryCss='alert-message block-message error fade in';
	
	/**
	 * Displays an alert box populated with a summary of validation errors for one or several models.
	 * @param mixed $model the models whose input errors are to be displayed. This can be either
	 * a single model or an array of models.
	 * @param string $header a piece of HTML code that appears in front of the errors
	 * @param string $footer a piece of HTML code that appears at the end of the errors
	 * @param array $htmlOptions additional HTML attributes to be rendered in the container div tag.
	 * This parameter has been available since version 1.0.7.
	 * A special option named 'firstError' is recognized, which when set true, will
	 * make the error summary to show only the first error message of each attribute.
	 * If this is not set or is false, all error messages will be displayed.
	 * This option has been available since version 1.1.3.
	 * @return string the error summary. Empty if no errors are found.
	 * @see CModel::getErrors
	 * @see errorSummaryCss
	 */
	public static function errorSummary($model,$header=null,$footer=null,$htmlOptions=array())
	{
		$content='';
		if(!is_array($model))
			$model=array($model);
		if(isset($htmlOptions['firstError']))
		{
			$firstError=$htmlOptions['firstError'];
			unset($htmlOptions['firstError']);
		}
		else
			$firstError=false;
		foreach($model as $m)
		{
			foreach($m->getErrors() as $errors)
			{
				foreach($errors as $error)
				{
					if($error!='')
						$content.="<li>$error</li>\n";
					if($firstError)
						break;
				}
			}
		}
		if($content!=='')
		{
			if($header===null)
				$header='​<p><strong>'.Yii::t('yii','Please fix the following input errors:').'</strong></p>';
			$widget=Yii::app()->getWidgetFactory()->createWidget(Yii::app()->controller,'BAlert',array(
				'content'=>$header."\n<ul>\n$content</ul>".$footer,
				'type'=>'error',
				'isBlock'=>true,
			));
			$widget->init();
			ob_start();
			$widget->run();
			return ob_get_clean();
		}
		else
			return '';
	}

	public static $errorMessageCss='help-inline';
	
	/**
	 * Displays the first validation error for a model attribute.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute name
	 * @param array $htmlOptions additional HTML attributes to be rendered in the container div tag.
	 * This parameter has been available since version 1.0.7.
	 * @return string the error display. Empty if no errors are found.
	 * @see CModel::getErrors
	 * @see errorMessageCss
	 */
	public static function error($model,$attribute,$htmlOptions=array())
	{
		$error=$model->getError($attribute);
		if($error!='')
		{
			if(!isset($htmlOptions['class']))
				$htmlOptions['class']=self::$errorMessageCss;
			return self::tag('span',$htmlOptions,$error);
		}
		else
			return '';
	}
}