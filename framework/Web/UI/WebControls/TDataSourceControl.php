<?php
/**
 * IDataSource, TDataSourceControl, TReadOnlyDataSource class file
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.pradosoft.com/
 * @copyright Copyright &copy; 2005-2014 PradoSoft
 * @license http://www.pradosoft.com/license/
 * @package Prado\Web\UI\WebControls
 */

namespace Prado\Web\UI\WebControls;

/**
 * TDataSourceControl class
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package Prado\Web\UI\WebControls
 * @since 3.0
 */
abstract class TDataSourceControl extends TControl implements IDataSource
{
	public function getView($viewName)
	{
		return null;
	}

	public function getViewNames()
	{
		return array();
	}

	public function onDataSourceChanged($param)
	{
		$this->raiseEvent('OnDataSourceChanged',$this,$param);
	}

	public function focus()
	{
		throw new TNotSupportedException('datasourcecontrol_focus_unsupported');
	}

	public function getEnableTheming()
	{
		return false;
	}

	public function setEnableTheming($value)
	{
		throw new TNotSupportedException('datasourcecontrol_enabletheming_unsupported');
	}

	public function getSkinID()
	{
		return '';
	}

	public function setSkinID($value)
	{
		throw new TNotSupportedException('datasourcecontrol_skinid_unsupported');
	}

	public function getVisible($checkParents=true)
	{
		return false;
	}

	public function setVisible($value)
	{
		throw new TNotSupportedException('datasourcecontrol_visible_unsupported');
	}
}
