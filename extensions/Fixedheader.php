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
class Fixedheader extends BaseExtension
{
	// The files are not web directory accessible, therefore we need
	// to specify the sourcePath property. Notice the @bower alias used.
	public $sourcePath = '@bower/datatables-fixedheader';
	
	public $css = [
		'css/dataTables.fixedHeader.css',
	];
	
	public $js = [
		'js/dataTables.fixedHeader.js',	
	];
	
	protected $constructor = 'FixedHeader';
}