<?php
/**
 * TControl, TControlCollection, TEventParameter and INamingContainer class file
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.pradosoft.com/
 * @copyright Copyright &copy; 2005-2014 PradoSoft
 * @license http://www.pradosoft.com/license/
 * @package Prado\Web\UI
 */

namespace Prado\Web\UI;

/**
 * TCompositeLiteral class
 *
 * TCompositeLiteral is used internally by {@link TTemplate} for representing
 * consecutive static strings, expressions and statements.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package Prado\Web\UI
 * @since 3.0
 */
class TCompositeLiteral extends TComponent implements IRenderable, IBindable
{
	const TYPE_EXPRESSION=0;
	const TYPE_STATEMENTS=1;
	const TYPE_DATABINDING=2;
	private $_container=null;
	private $_items=array();
	private $_expressions=array();
	private $_statements=array();
	private $_bindings=array();

	/**
	 * Constructor.
	 * @param array list of items to be represented by TCompositeLiteral
	 */
	public function __construct($items)
	{
		$this->_items=array();
		$this->_expressions=array();
		$this->_statements=array();
		foreach($items as $id=>$item)
		{
			if(is_array($item))
			{
				if($item[0]===self::TYPE_EXPRESSION)
					$this->_expressions[$id]=$item[1];
				else if($item[0]===self::TYPE_STATEMENTS)
					$this->_statements[$id]=$item[1];
				else if($item[0]===self::TYPE_DATABINDING)
					$this->_bindings[$id]=$item[1];
				$this->_items[$id]='';
			}
			else
				$this->_items[$id]=$item;
		}
	}

	/**
	 * @return TComponent container of this component. It serves as the evaluation context of expressions and statements.
	 */
	public function getContainer()
	{
		return $this->_container;
	}

	/**
	 * @param TComponent container of this component. It serves as the evaluation context of expressions and statements.
	 */
	public function setContainer(TComponent $value)
	{
		$this->_container=$value;
	}

	/**
	 * Evaluates the expressions and/or statements in the component.
	 */
	public function evaluateDynamicContent()
	{
		$context=$this->_container===null?$this:$this->_container;
		foreach($this->_expressions as $id=>$expression)
			$this->_items[$id]=$context->evaluateExpression($expression);
		foreach($this->_statements as $id=>$statement)
			$this->_items[$id]=$context->evaluateStatements($statement);
	}

	/**
	 * Performs databindings.
	 * This method is required by {@link IBindable}
	 */
	public function dataBind()
	{
		$context=$this->_container===null?$this:$this->_container;
		foreach($this->_bindings as $id=>$binding)
			$this->_items[$id]=$context->evaluateExpression($binding);
	}

	/**
	 * Renders the content stored in this component.
	 * This method is required by {@link IRenderable}
	 * @param ITextWriter
	 */
	public function render($writer)
	{
		$writer->write(implode('',$this->_items));
	}
}