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
class Colvis extends BaseExtension
{
	// The files are not web directory accessible, therefore we need
	// to specify the sourcePath property. Notice the @bower alias used.
	public $sourcePath = '@bower/datatables-colvis';
	
	public $js = [
		'js/dataTables.colVis.js',
	];
	
	protected $constructor = 'ColVis'; 
	
	public function registerAssetFiles($view)
	{
		if (!empty($this->gridView->plugins['jqueryui'])) {
			$this->css = ['css/dataTables.colvis.jqueryui.css'];
		} else {
			$this->css = ['css/dataTables.colVis.css'];
		}
		parent::registerAssetFiles($view);
	}
}