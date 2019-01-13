<?php
namespace app\extensions\table;

use Yii;
use yii\helpers\Html;

/**
 * Description of ModelTableWidget
 *
 * @author herbert
 */

class ModelTableWidget 
	extends \app\extensions\ttwidget\TtWidget
{
	var $tableId; 
	var $models;
	var $pages;
	var $columns;
	var $tableClass = 'table table-condensed table-hover';
	var $options = array();
	var $showHead = true;
	
	protected $tagName = 'table';
	protected $tagNameHead = 'thead';
	protected $tagNameBody = 'tbody';
	protected $tagNameFoot = 'tfoot';
	protected $tagRow = 'tr';
	protected $tagHeadCol = 'th';
	protected $tagCol = 'td';
	
	function init(){
		
		parent::init();
	}
	
	function run(){
		
		AssetTable::register($this->getView());

		$txt = $this->_displayPager();
		$txt.= $this->_displayTable();
		$txt.= $this->_displayPager();
		return $txt;
	}
	
	function _displayTable() {
		
		$columns = $this->_getColumns();
		$attrParams = $this->_getAttrParams($columns);
		
		$txt = Html::openTag($this->tagName, $this->_tableOptions());
		$txt.= $this->_displayTableHead($columns);
		$txt.= $this->_displayTableBody($columns, $attrParams);
		$txt.= $this->_displayTableFoot($columns);
		$txt.= Html::closeTag($this->tagName);
		return $txt;
	}
	
	function _tableOptions() {
		
		$htmlOptions = array(
			'class' => $this->tableClass,
		);
		
		if(isset($this->tableId)) {
			$htmlOptions['id'] = $this->tableId;
		}
		return $htmlOptions;
	}
	
	function _displayPager() {
		
		if(!isset($this->pages)) {
			return;
		}
		
		//Yii::log("+ _displayPager ()");
		return LinkPager::widget([
			'pagination' => $this->pages,
		]);
		//Yii::log("- _displayPager ()");
	}
	
	function _getColumns() {
		
		$columns = array();
		foreach ($this->columns as $col) {
			$columns[] = $col;
		}
		
		if (array_key_exists('edit', $this->options) && ($this->options['edit'] == true)) {
			$columns[] = 'functions';
		}
		return $columns;
	}
	
	function _getAttrParams($columns) {
		
		if (count($this->models) == 0) {
			$model = null;
		} else {
			$model = $this->models[0];
		}
		
		$control = $this->getController();
		$attrParams = array();
		
		foreach ($columns as $col) {
			$attrParams[$col] = $control->attributeParams($col, $model, $this->options);
		}
		return $attrParams;
	}

	function _displayTableHead($columns, $attrParams = null) {
		
		if ($this->showHead !== true) {
			return;
		}
			
		$txt = Html::openTag($this->tagNameHead);
		$txt.= $this->_displayHeadRows($columns, $attrParams);
		$txt.= Html::closeTag($this->tagNameHead);
		return $txt;
	}
		
	/*
	 * default implementation of the table head displays only one row
	 */
	function _displayHeadRows($columns, $attrParams = null) {
						
		return $this->_displayRow($columns, 
				$this->_getHeadItems($columns), 
				$this->_getHeadAttributes($columns, $attrParams), 
				$this->tagHeadCol);
	}
	
	/*
	 * get contents of the rows in the headline
	 */
	function _getHeadItems($columns) {

		if (count($this->models) == 0) {
			return array();
		}
		
		$attrLabels = $this->models[0]->attributeLabels();
		$colHeads = array();
		
		foreach ($columns as $col) {
			
			if (array_key_exists($col, $attrLabels)) {
				$colHeads[$col] = $attrLabels[$col];
			} else {
				$colHeads[$col] = "[$col]";
			}			
		}
		return $colHeads;
	}
	
	/*
	 * get contents of one row in the headline
	 */
	function _getHeadItem($columnName) {

		if (count($this->models) == 0) {
			return array();
		}
		
		$attrLabels = $this->models[0]->attributeLabels();
		
		if (array_key_exists($columnName, $attrLabels)) {
			return $attrLabels[$columnName];
		} else {
			return "[$columnName]";
		}
	}
	
	/*
	 * get attributes of the rows in the headline
	 */
	function _getHeadAttributes($columns, $attrParams = null) {

		$options = array();
		foreach ($columns as $col) {
			
			if (is_array($attrParams) && array_key_exists($col, $attrParams)) {
				
				$options[$col] = $attrParams[$col];	
			} else {
				$options[$col] = array();
			}
		}
		return $options;
	}
	

	function _displayTableBody($columns, $attrParams) {
		
		$control = $this->getController();
		
		$txt = CHtml::openTag($this->tagNameBody);
		foreach($this->models as $model) {
			
			if(!$model->displayTableLine($attrParams)) {
				continue;
			}
			
			$items = array();
			$options = array();
			$options['row'] = $control->attributeParams('row', $model, $this->options);
			
			foreach($columns as $col) {
				
				if (!$model->displayTableColumn($col)) {
					continue;
				}
				
				switch($col) {
					
					case 'functions':
						$items['functions'] = $this->_getButtons($model).
																	CHtml::tag('br').
																	$this->_getTimestamp($model);
						break;
					case 'functions_ext':
						$items['functions_ext'] = $this->_getButtons($model);
						break;
					default:
						$items[$col] = $model->attributeValue($col, array_key_exists($col, $attrParams)?$attrParams[$col]:null);
				}
				
				$options[$col] = $model->attributeTableOptions($col);
			}
			
			$txt = $this->_displayRow($columns, $items, $options, $this->tagCol);
		}
		$txt = Html::closeTag($this->tagNameBody);
		return $txt;
	}
	
	function _displayTableFoot($columns) {
		
		// for subclasses
		//echo CHtml::openTag($this->tagNameBody);
		//echo CHtml::closeTag($this->tagNameBody);
		return null;
	}
	
	function _displayRow ($columns, $items, $options, $itemTag) {
		
		$txt = CHtml::openTag($this->tagRow, $this->_rowOptions($options));
		
		foreach($columns as $colName) {
			
			if(!array_key_exists($colName, $items)) {
				continue;
			}
			$opt = $this->_colOptions($colName, $options);
			//Yii::log ("$itemTag [$colName] = [".$items[$colName]."] [".print_r($opt, true)."]");
			
			$txt.= Html::tag($itemTag,	$items[$colName], $opt);
		}
		$txt.= Html::closeTag($this->tagRow)."\r\n";
		return $txt;
	}
	
	protected function _rowOptions($options) {
		
		if (!isset($options['row'])) {
			$rowOptions = array();
		} else {
			$rowOptions = $options['row'];
		}
		
		return $rowOptions;
	}
	
	protected function _colOptions($colName, $options){
		
		return array_key_exists($colName, $options)?$options[$colName]:array();			
	}
	
	function _getButtons($model) {
		
		$txt = "<nobr>";
		$txt.= $this->getController()->getModelTableButtons($model, $this->options);
		$txt.= "</nobr>";
		return $txt;
	}
	
	function _getTimestamp($model) {
		
		return app\extensions\ttwidget\TimeStampDisplay::widget([
				'model' => $model,
		]);
	}	

}
