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
class Scroller extends BaseExtension
{
	// The files are not web directory accessible, therefore we need
	// to specify the sourcePath property. Notice the @bower alias used.
	public $sourcePath = '@bower/datatables-scroller';
	
	public $css = [
		'css/dataTables.scroller.css',
	];
	
	public $js = [
		'js/dataTables.scroller.js',
	];
	
	/**
	 * 
	 * @param \yii\web\View $view
	 * @param string $id
	 * @param array $options
	 * @return string
	 */
	public static function registerConstructor($view, $id, $options)
	{
		static::register($view);
		return '';
	}
}