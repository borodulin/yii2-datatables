<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\extensions;

/**
 * AutoFill gives an Excel like option to a DataTable to click and drag over multiple cells,
 * filling in information over the selected cells and incrementing numbers as needed.
 * @link http://datatables.net/extensions/autofill/options
 * @author Andrey Borodulin
 */
class Autofill extends BaseExtension 
{
	// The files are not web directory accessible, therefore we need
	// to specify the sourcePath property. Notice the @bower alias used.
	public $sourcePath = '@bower/datatables-autofill';
	
	public $css = [
		'css/dataTables.autoFill.css',
	];
	
	public $js = [
		'js/dataTables.autoFill.js',
	];
	
	protected $constructor = 'AutoFill';
}