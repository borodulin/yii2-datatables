<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\extensions;

/**
 * @author Andrey Borodulin
 */
class Tabletools extends BaseExtension
{
	// The files are not web directory accessible, therefore we need
	// to specify the sourcePath property. Notice the @bower alias used.
	public $sourcePath = '@bower/datatables-tabletools';
	
	public $css = [
		'css/dataTables.tableTools.css',
	];
	
	public $js = [
		'js/dataTables.tableTools.js',
	];
	
	protected $constructor = 'TableTools';
}