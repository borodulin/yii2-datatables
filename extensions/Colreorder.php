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
class Colreorder extends BaseExtension
{
	// The files are not web directory accessible, therefore we need
	// to specify the sourcePath property. Notice the @bower alias used.
	public $sourcePath = '@bower/datatables-colreorder';
	
	public $css = [
		'css/dataTables.colReorder.css',
	];
	
	public $js = [
		'js/dataTables.colReorder.js',
	];
	
	protected $constructor = 'ColReorder';

}