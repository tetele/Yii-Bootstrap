<?php 
/**
 * BActiveForm class file
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
 * BActiveForm is a small wrapper on top of Yii's own CActiveRecord widget. It allows easy integration of
 * Bootstrap-specific widgets
 *
 * @author Tudor Sandu <tm.sandu@gmail.com>
 * @version 0.2
 * @package bootstrap
 * @since 0.1
 */
class BActiveForm extends CActiveForm {
	public $type;
	public function init() {
		// Set input container for error class addition when validation fails
		if(isset($this->clientOptions)) {
			if(!isset($this->clientOptions['inputContainer']))
				$this->clientOptions['inputContainer'] = '.control-group';
		} else
			$this->clientOptions = array('inputContainer' => '.control-group');
			
		// Set default for class
		if(!isset($this->type) || !in_array($this->type,array('vertical','inline','search','horizontal')))
			$this->type = 'horizontal';
		$class = 'form-'.$this->type;
		if(isset($this->htmlOptions)) {
			if(!isset($this->htmlOptions['class']))
				$this->htmlOptions['class'] = $class;
			else
				$this->htmlOptions['class'] .= ' '.$class;
		} else
			$this->htmlOptions = array('class' => $class);
		// then do($magic)
		parent::init();
	}
	
	/**
	 * Returns input container class for any given attribute, depending on validation conditions.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute name
	 */
	public function fieldClass($model, $attribute) {
		$class = 'control-group';
		if($model->getError($attribute))
			$class .= ' error';
		return $class;
	}
	
	public $errorMessageCssClass='help-inline';

	/**
	 * Displays the first validation error for a model attribute.
	 * This is similar to {@link BHtml::error} except that it registers the model attribute
	 * so that if its value is changed by users, an AJAX validation may be triggered.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute name
	 * @param array $htmlOptions additional HTML attributes to be rendered in the container div tag.
	 * Besides all those options available in {@link BHtml::error}, the following options are recognized in addition:
	 * <ul>
	 * <li>validationDelay</li>
	 * <li>validateOnChange</li>
	 * <li>validateOnType</li>
	 * <li>hideErrorMessage</li>
	 * <li>inputContainer</li>
	 * <li>errorCssClass</li>
	 * <li>successCssClass</li>
	 * <li>validatingCssClass</li>
	 * <li>beforeValidateAttribute</li>
	 * <li>afterValidateAttribute</li>
	 * </ul>
	 * These options override the corresponding options as declared in {@link options} for this
	 * particular model attribute. For more details about these options, please refer to {@link clientOptions}.
	 * Note that these options are only used when {@link enableAjaxValidation} or {@link enableClientValidation}
	 * is set true.
	 *
	 * When client-side validation is enabled, an option named "clientValidation" is also recognized.
	 * This option should take a piece of JavaScript code to perform client-side validation. In the code,
	 * the variables are predefined:
	 * <ul>
	 * <li>value: the current input value associated with this attribute.</li>
	 * <li>messages: an array that may be appended with new error messages for the attribute.</li>
	 * <li>attribute: a data structure keeping all client-side options for the attribute</li>
	 * </ul>
	 * @param boolean $enableAjaxValidation whether to enable AJAX validation for the specified attribute.
	 * Note that in order to enable AJAX validation, both {@link enableAjaxValidation} and this parameter
	 * must be true.
	 * @param boolean $enableClientValidation whether to enable client-side validation for the specified attribute.
	 * Note that in order to enable client-side validation, both {@link enableClientValidation} and this parameter
	 * must be true. This parameter has been available since version 1.1.7.
	 * @return string the validation result (error display or success message).
	 * @see BHtml::error
	 */
	public function error($model,$attribute,$htmlOptions=array(),$enableAjaxValidation=true,$enableClientValidation=true)
	{
		if(!$this->enableAjaxValidation)
			$enableAjaxValidation=false;
		if(!$this->enableClientValidation)
			$enableClientValidation=false;

		if(!isset($htmlOptions['class']))
			$htmlOptions['class']=$this->errorMessageCssClass;

		if(!$enableAjaxValidation && !$enableClientValidation)
			return BHtml::error($model,$attribute,$htmlOptions);

		$id=BHtml::activeId($model,$attribute);
		$inputID=isset($htmlOptions['inputID']) ? $htmlOptions['inputID'] : $id;
		unset($htmlOptions['inputID']);
		if(!isset($htmlOptions['id']))
			$htmlOptions['id']=$inputID.'_em_';

		$option=array(
			'id'=>$id,
			'inputID'=>$inputID,
			'errorID'=>$htmlOptions['id'],
			'model'=>get_class($model),
			'name'=>BHtml::resolveName($model, $attribute),
			'enableAjaxValidation'=>$enableAjaxValidation,
		);

		$optionNames=array(
			'validationDelay',
			'validateOnChange',
			'validateOnType',
			'hideErrorMessage',
			'inputContainer',
			'errorCssClass',
			'successCssClass',
			'validatingCssClass',
			'beforeValidateAttribute',
			'afterValidateAttribute',
		);
		foreach($optionNames as $name)
		{
			if(isset($htmlOptions[$name]))
			{
				$option[$name]=$htmlOptions[$name];
				unset($htmlOptions[$name]);
			}
		}
		if($model instanceof CActiveRecord && !$model->isNewRecord)
			$option['status']=1;

		if($enableClientValidation)
		{
			$validators=isset($htmlOptions['clientValidation']) ? array($htmlOptions['clientValidation']) : array();
			foreach($model->getValidators($attribute) as $validator)
			{
				if($enableClientValidation && $validator->enableClientValidation)
				{
					if(($js=$validator->clientValidateAttribute($model,$attribute))!='')
						$validators[]=$js;
				}
			}
			if($validators!==array())
				$option['clientValidation']="js:function(value, messages, attribute) {\n".implode("\n",$validators)."\n}";
		}

		$html=BHtml::error($model,$attribute,$htmlOptions);
		if($html==='')
		{
			if(isset($htmlOptions['style']))
				$htmlOptions['style']=rtrim($htmlOptions['style'],';').';display:none';
			else
				$htmlOptions['style']='display:none';
			$html=BHtml::tag('span',$htmlOptions,'');
		}

		$this->attributes[$inputID]=$option;
		return $html;
	}

	/**
	 * Displays a summary of validation errors for one or several models.
	 * This method is very similar to {@link BHtml::errorSummary} except that it also works
	 * when AJAX validation is performed.
	 * @param mixed $models the models whose input errors are to be displayed. This can be either
	 * a single model or an array of models.
	 * @param string $header a piece of HTML code that appears in front of the errors
	 * @param string $footer a piece of HTML code that appears at the end of the errors
	 * @param array $htmlOptions additional HTML attributes to be rendered in the container div tag.
	 * @return string the error summary. Empty if no errors are found.
	 * @see BHtml::errorSummary
	 */
	public function errorSummary($models,$header=null,$footer=null,$htmlOptions=array())
	{
		if(!$this->enableAjaxValidation && !$this->enableClientValidation)
			return BHtml::errorSummary($models,$header,$footer,$htmlOptions);

		if(!isset($htmlOptions['id']))
			$htmlOptions['id']=$this->id.'_es_';
		$html=BHtml::errorSummary($models,$header,$footer,$htmlOptions);
		if($html==='')
		{
			if($header===null)
				$header='<p><strong>'.Yii::t('yii','Please fix the following input errors:').'</strong></p>';
			if(!isset($htmlOptions['class']))
				$htmlOptions['class']=BHtml::$errorSummaryCss;
			$htmlOptions['style']=isset($htmlOptions['style']) ? rtrim($htmlOptions['style'],';').';display:none' : 'display:none';
			$html=$header."\n<ul><li>dummy</li></ul>".$footer;
			return $this->widget('BAlert',array('content'=>$html,'type'=>'error','isBlock'=>true,'htmlOptions'=>$htmlOptions),true);
		}

		$this->summaryID=$htmlOptions['id'];
		return $html;
	}
	
	public function checkBox(CModel $model, $attribute, $htmlOptions=array()) {
		return BHtml::activeCheckBox($model, $attribute, $htmlOptions);
	}
	
	public function labelEx(CModel $model, $attribute, $htmlOptions=array())
	{
		$htmlOptions['class'] = 'control-label' . (isset($htmlOptions['class']) ? ($htmlOptions['class'].' ') : '');
		return CHtml::activeLabelEx($model,$attribute,$htmlOptions);
	}
}